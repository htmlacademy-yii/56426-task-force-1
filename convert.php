<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');

use HtmlAcademy\Tools\Converter;

// city

$city = new Converter('data/cities.csv', 'src/sql/city.sql', 'city');
$cityCount = $city->convert();
printf("city: %d\n", $cityCount);

// user

$user = new Converter('data/users.csv', 'src/sql/user.sql', 'user');
$userCount = $user->convert();
printf("user: %d\n", $userCount);

// profile

$profile = new Converter('data/profiles.csv', 'src/sql/profile.sql', 'profile');
$profileCount = $profile->convert(['user_id' => 0, 'city_id' => $cityCount]);
printf("profile: %d\n", $profileCount);

// skill

$skill = new Converter('data/skills.csv', 'src/sql/skill.sql', 'skill');
$skillCount = $skill->convert();
printf("skill: %d\n", $skillCount);

// category

$category = new Converter('data/categories.csv', 'src/sql/category.sql', 'category');
$categoryCount = $category->convert();
printf("category: %d\n", $categoryCount);

// task

$task = new Converter('data/tasks.csv', 'src/sql/task.sql', 'task');
$taskCount = $task->convert(['customer_id' => $userCount]);
printf("task: %d\n", $taskCount);

// reply

$reply = new Converter('data/replies.csv', 'src/sql/reply.sql', 'reply');
$replyCount = $reply->convert(['task_id' => $taskCount, 'contractor_id' => $userCount]);
printf("reply: %d\n", $replyCount);
