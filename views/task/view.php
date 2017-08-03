<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="template/css/bootstrap.min.css">
    <link rel="stylesheet" href="template/css/style.css">
    <title>Tasker</title>
</head>
<body>
    <header class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                <?php if (User::isGuest()): ?>
                            <li class="login-btn"><a href="login">Log in</a></li>
                        </ul>
                    </div>
                    <div class="login-panel">
                        <form action="login" class="login-form" name="loginForm">
                            <input type="text" class="form-control form-group" name="login" placeholder="Login">
                            <input type="password" class="form-control form-group" name="password" placeholder="Password">
                            <button type="button" class="btn btn-primary btn-block login-request">Log in</button>
                        </form>
                    </div>                    
                <?php else: ?>
                            <li><a><?php if(isset($user['name'])) { echo $user['name']; } ?></a></li>
                            <li class="logout-btn"><a href="logout">Log out</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
        </div>
    </header>
    <section class="container body-content">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add task</h4>
                    </div>
                    <div class="modal-body">
                        <form action="posttask" enctype="multipart/form-data" class="task-form" name="taskForm">
                            <input type="text" class="form-control form-group t-name" name="name" placeholder="Name">
                            <input type="email" class="form-control form-group t-email" name="email" placeholder="Email">
                            <textarea class="form-control form-group t-text" name="text" placeholder="Task text"></textarea>
                            <div class="form-group group clearfix">
                                <input type="file" class="load-img-btn" name="image">
                                <button type="button" class="btn btn-default preview-btn">Preview</button>
                                <div class="preview">
                                    <div class="preview-name"></div>
                                    <div class="preview-email"></div>
                                    <div class="preview-text"></div>
                                    <img src="" alt="Preview image" class="preview-image">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-block send-task">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-default btn-lg btn-block add-task-btn" data-toggle="modal" data-target="#myModal">Add task</button>
        <div class="ajax-table"></div>
    </section>
    <script src="template/js/jquery-3.2.1.min.js"></script>    
    <script src="template/js/bootstrap.min.js"></script>    
    <script src="template/js/sorting.js"></script>
    <script src="template/js/ajax.js"></script>
    <script src="template/js/run.js"></script>
</body>
</html>