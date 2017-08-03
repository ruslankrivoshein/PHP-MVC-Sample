<?php
$isAdmin = User::isAdmin();
$result = '';
$result .= "<table class='table'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Task</th>
                        <th>Image</th>
                        <th>Status</th>";
if ($isAdmin) $result .= "<th>Edit<sub>*</sub></th>";
$result .=          "</tr>
                </thead>
                <tbody>";
foreach ($tasksList as $task) {
    $status = $task['status'] == 0 ? 'Executing' : 'Completed';
    $statusView = $task['status'] == 0 ? '' : 'checked';
    $result .= "<tr>
                    <td>".$task['id']."</td>
                    <td>".$task['name']."</td>
                    <td>".$task['email']."</td>";
    if ($isAdmin) {
        $result .=  "<td><textarea>".$task['text']."</textarea></td>
                    <td><img src='".$task['image']."' alt='cover'></td>
                    <td>
                        <input type='checkbox' ".$statusView.">
                    </td>
                    <td>
                        <button type='button' class='btn btn-default save-task-btn' data-id='".$task['id']."'>Save</button>
                    </td>
                </tr>";
    } else {
        $result .=  "<td>".$task['text']."</td>
                    <td><img src='".$task['image']."' alt='cover'></td>
                    <td>".$status."</td>
                </tr>";
    }
}
$result .=     "</tbody>
            </table>
            <nav class='pages'>".$pagination->get()."</nav>";
return $result;
