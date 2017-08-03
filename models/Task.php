<?php

include_once ROOT. '/components/ImageTools/AcImage.php';

class Task
{
    const SHOW_NUMBER = 3;

    // get tasks on specified page
    public static function getTaskList($page)
    {
        $offset = ($page - 1) * self::SHOW_NUMBER;

        $db = Database::getConnection();
        $tasksList = array();
        $result = $db->query("SELECT t.id, t.text, t.image, t.status, u.name, u.email FROM tasks AS t INNER JOIN users AS u ON t.user_id = u.id ORDER BY id DESC LIMIT ".self::SHOW_NUMBER." OFFSET ".$offset);
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $tasksList[$i]['id'] = $row['id'];
            $tasksList[$i]['name'] = $row['name'];
            $tasksList[$i]['email'] = $row['email'];
            $tasksList[$i]['text'] = $row['text'];
            $tasksList[$i]['image'] = $row['image'];
            $tasksList[$i]['status'] = $row['status'];
            $i++;
        }

        $db->close();
        return $tasksList;
    }

    public static function postTask()
    {
        // get image name and extension
        if ($_FILES['image']['name'] != '') {
            $file = $_FILES['image'];
            $fileName = $file['name'];
            $fileExt = explode('.', $fileName);
            $fileExt = strtolower(end($fileExt));
            $extensions = array('jpg', 'gif', 'png');
            $fileDestination = '';

            // if picture has valid extension, set its unique name, resize and save in folder on server
            if (in_array($fileExt, $extensions)) {
                if ($file['error'] == 0) {
                    $fileNameNew = uniqid('img', true).'.'.$fileExt;
                    $fileDestination = 'template/img/'.$fileNameNew;
                    $resizedFile = AcImage::createImage($file['tmp_name']);
                    $resizedFile->resize(320, 240);
                    $resizedFile->save($fileDestination);
                }
            }
        } else {
            // set stub image when user didn't send any picture
            $fileDestination = 'template/img/empty.jpg';
        }

        $db = Database::getConnection();

        if (!isset($_POST['id'])) {
            // if user sends a task first time, this is a new user, therefore, add it in DB
            $addUserQuery = $db->prepare("INSERT INTO users (`id`, `name`, `email`, `login`, `password`) VALUES (NULL, ?, ?, NULL, NULL)");
            $addUserQuery->bind_param('ss', $_POST['name'], $_POST['email']);
            $addUserQuery->execute();
            // get last added user
            $thisUser = $db->query("SELECT * FROM users ORDER BY id DESC LIMIT 1");
            $user = $thisUser->fetch_object();
            // save its data in browser
            setcookie('id', $user->id);
            setcookie('name', $_POST['name']);
            setcookie('email', $_POST['email']);
            // add new task binded to this user
            $addTaskQuery = $db->prepare("INSERT INTO tasks (`id`, `user_id`, `text`, `image`, `status`) VALUES (NULL, ?, ?, ?, 0)");
            $addTaskQuery->bind_param('dss', $user->id, $_POST['text'], $fileDestination);
            $addTaskQuery->execute();
        } else {
            // if 'id' has been sent, this means user isn't new, so add only task binded to this user
            $addTaskQuery = $db->prepare("INSERT INTO tasks (`id`, `user_id`, `text`, `image`, `status`) VALUES (NULL, ?, ?, ?, 0)");
            $addTaskQuery->bind_param('dss', $_POST['id'], $_POST['text'], $fileDestination);
            $addTaskQuery->execute();
        }

        $db->close();
        return true;
    }

    public static function editTask()
    {
        $db = Database::getConnection();
        $query = $db->prepare("UPDATE tasks SET text = ?, status = ? WHERE id = ?");
        $query->bind_param('sdd', $_POST['text'], $_POST['status'], $_POST['id']);
        $query->execute();

        $db->close();
        return true;
    }

    public static function getTotalTasks()
    {
        $db = Database::getConnection();
        $query = $db->query("SELECT COUNT('id') AS count FROM tasks");
        $result = $query->fetch_object();
        
        $db->close();
        return $result->count;
    }
}
