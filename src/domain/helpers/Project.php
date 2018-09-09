<?php

namespace yii2lab\init\domain\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii2lab\extension\arrayTools\helpers\ArrayIterator;
use yii2lab\domain\data\Query;
use yii2lab\extension\yii\helpers\FileHelper;

class Project {

    static $baseDir = ROOT_DIR . SL . 'environments/config/projects';

    public static function all()
    {
        $projectFileNames = self::findProjects();
        $projects = [];
        foreach ($projectFileNames as $name) {
            $project = self::loadProject($name);
            $projects[$project['name']] = $project;
        }
        return $projects;
    }

    public static function allTitles()
    {
        $projects = Project::all();
        $projectTitles = ArrayHelper::getColumn($projects, 'title');
        $projectTitles = array_values($projectTitles);
        return $projectTitles;
    }

    public static function first()
    {
        $projects = Project::all();
        return \yii2mod\helpers\ArrayHelper::first($projects);
    }

    public static function oneByTitle($title)
    {
        $projects = Project::all();
        $query = Query::forge();
        $query->where('title', $title);
        return ArrayIterator::oneFromArray($query, $projects);
    }

    public static function oneByName($name)
    {
        $projects = Project::all();
        $query = Query::forge();
        $query->where('name', $name);
        return ArrayIterator::oneFromArray($query, $projects);
    }

    private static function loadProject($name) {
        $project = @include(self::$baseDir . SL . $name . DOT . 'php');
        $project['name'] = $name;
        $project['title'] = !empty($project['title']) ? $project['title'] : Inflector::titleize($project['name']);
        $project['path'] = !empty($project['path']) ? $project['path'] : $project['name'];
        return $project;
    }

    private static function findProjects() {
        $projectFileNames = FileHelper::scanDir(self::$baseDir);
        $projects = [];
        foreach ($projectFileNames as $name) {
            $projects[] = FileHelper::fileRemoveExt($name);
        }
        return $projects;
    }
}
