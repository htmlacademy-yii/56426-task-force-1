<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');

use HtmlAcademy\Tools\Converter;

$sourcePath = 'data/';
$targetPath = 'src/sql/';

// city

$city = new Converter($sourcePath.'cities.csv', $targetPath.'city.sql', 'city');
$cityCount = $city->convert();
printf("city: %d\n", $cityCount);

// user

$user = new Converter($sourcePath.'users.csv', $targetPath.'user.sql', 'user');
$userCount = $user->convert();
printf("user: %d\n", $userCount);

// profile

$profile = new Converter($sourcePath.'profiles.csv', $targetPath.'profile.sql', 'profile');
$profileCount = $profile->convert(['user_id' => 0, 'city_id' => $cityCount]);
printf("profile: %d\n", $profileCount);

// skill

$skill = new Converter($sourcePath.'skills.csv', $targetPath.'skill.sql', 'skill');
$skillCount = $skill->convert();
printf("skill: %d\n", $skillCount);

// category

$category = new Converter($sourcePath.'categories.csv', $targetPath.'category.sql', 'category');
$categoryCount = $category->convert();
printf("category: %d\n", $categoryCount);

// task

$task = new Converter($sourcePath.'tasks.csv', $targetPath.'task.sql', 'task');
$taskCount = $task->convert(['customer_id' => $userCount]);
printf("task: %d\n", $taskCount);

// reply

$reply = new Converter($sourcePath.'replies.csv', $targetPath.'reply.sql', 'reply');
$replyCount = $reply->convert(['task_id' => $taskCount, 'contractor_id' => $userCount]);
printf("reply: %d\n", $replyCount);

// feedback

$feedback = new Converter($sourcePath.'opinions.csv', $targetPath.'feedback.sql', 'feedback');
$feedbackCount = $feedback->convert(['contractor_id' => $userCount]);
printf("feedback: %d\n", $feedbackCount);
