<html>
    <head>
        <meta charset="utf-8">
        <title>Bootstrap, from Twitter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Default JS -->
        <?php if(!empty($app_a_default_js)){ 
            foreach($app_a_default_js as $item){ ?>
                <script type="text/javascript" src="<?php echo $app_base_url;?>asset/public/js/<?php echo $item;?>.js"></script>
        <?php } }?>
                
        <!-- Front end JS -->
        <?php if(!empty($app_a_frontend_js)){ 
            foreach($app_a_frontend_js as $item){ ?>
                <script type="text/javascript" src="<?php echo $app_base_url;?>asset/frontend/js/<?php echo $item;?>.js"></script>
        <?php } }?>   
                
        <!-- Bootstrap -->        
        <script type="text/javascript" src="<?php echo $app_base_url;?>bootstrap/js/bootstrap.min.js"></script>                    
        <link href="<?php echo $app_base_url;?>bootstrap/css/bootstrap.min.css" rel="stylesheet" >       
        <link href="<?php echo $app_base_url;?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" > 
        
        <!-- Default CSS -->
        <?php if(!empty($app_a_default_css)){ 
            foreach($app_a_default_css as $item){ ?>
                <link href="<?php echo $app_base_url;?>asset/public/css/<?php echo $item;?>.css" rel="stylesheet" >
        <?php } }?>
                
        <!-- Front end CSS -->    
        <?php if(!empty($app_a_frontend_css)){ 
            foreach($app_a_frontend_css as $item){ ?>
                <link href="<?php echo $app_base_url;?>asset/frontend/css/<?php echo $item;?>.css" rel="stylesheet" >
        <?php } }?>
                
    </head>
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Home</a>
                    <div class="nav-collapse collapse">
                        <p class="navbar-text pull-right">
                            Logged in as <a href="#" class="navbar-link">Username</a>
                        </p>
                        <ul class="nav">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Nav header</li>
                                    <li><a href="#">Separated link</a></li>
                                    <li><a href="#">One more separated link</a></li>
                                </ul>
                            </li>
                        </ul>
                        <form class="navbar-form pull-right">
                            <input class="span2" type="text" placeholder="Email">
                            <input class="span2" type="password" placeholder="Password">
                            <button type="submit" class="btn">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                            <li class="nav-header">Sidebar</li>
                            <li class="active"><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li class="nav-header">Sidebar</li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li class="nav-header">Sidebar</li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                        </ul>
                    </div>
                </div>
                <div class="span10">
                    <div class="row-fluid">
                        <ul class="breadcrumb">
                            <li><a href="#">Home</a> <span class="divider">/</span></li>
                            <li><a href="#">Library</a> <span class="divider">/</span></li>
                            <li class="active">Data</li>
                        </ul>
                    </div>
                    <div class="row-fluid filterring">
                        <form action="" method="posr">
                            <div class="filterring-item">
                                <label>Select User Type</label>
                                <select class="span2">
                                    <option value="1">Administrator</option>
                                    <option value="2">Monitor</option>
                                    <option value="3">Member</option>
                                </select>
                            </div>
                            <div class="filterring-item">
                                <label>Select User Group</label>
                                <select class="span2">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="filterring-item">
                                <label>Filter 1</label>
                                <input type="text" placeholder="Type something…">
                            </div>
                            <div class="filterring">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn">Submit</button>
                                <button type="submit" class="btn">Reload</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="row-fluid ">
                        <form action="#" method="post" >
                            <div class="row-fluid">
                            <a class="btn">Add user</a>
                            <a class="btn" onclick="submit_form(this,'delete')">Delete user</a>
                        </div>
                            <table class="table table-striped table-bordered table-hover ">
                                <caption>List user</caption>
                                <thead>
                                    <th><input type="checkbox" name="checkall" id="checkall" onclick="qho.check_all()" ></th>
                                    <th>UserID      <i class="icon-arrow-up"></i></th>
                                    <th>Username    </th>
                                    <th>Email       </th>
                                    <th>Insertdate  </th>
                                    <th>Updatedate  </th>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($data)){
                                        foreach($data as $item){
                                            echo "<tr>
                                                    <td><input type='checkbox' name='checkedid[]' ></td>
                                                    <td>$item->id</td>
                                                    <td>$item->username</td>
                                                    <td>$item->email</td>
                                                    <td>2012/12/12</td>
                                                    <td>2012/12/12</td>
                                                </tr>";
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkedid[]" class="checked" onclick="qho.check_this(this)" ></td>
                                        <td>1</td>
                                        <td>
                                            Admin
                                            <div class="action">
                                                <a href="#" class="view">View</a>
                                                <a href="#" class="update">Update</a>
                                                <a href="#" class="delete">Delete</a>
                                            </div>
                                        </td>
                                        <td>admin@yahoo.com</td>
                                        <td>2012/12/12</td>
                                        <td>2012/12/12</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="checkedid[]" class="checked" onclick="qho.check_this(this)" ></td>
                                        <td>1</td>
                                        <td>
                                            Admin
                                            <div class="action">
                                                <a href="#" class="view">View</a>
                                                <a href="#" class="update">Update</a>
                                                <a href="#" class="delete">Delete</a>
                                            </div>
                                        </td>
                                        <td>admin@yahoo.com</td>
                                        <td>2012/12/12</td>
                                        <td>2012/12/12</td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" name="checkedid[]" class="checked" onclick="qho.check_this(this)" ></td>
                                        <td>1</td>
                                        <td>
                                            Admin
                                            <div class="action">
                                                <a href="#" class="view">View</a>
                                                <a href="#" class="update">Update</a>
                                                <a href="#" class="delete">Delete</a>
                                            </div>
                                        </td>
                                        <td>admin@yahoo.com</td>
                                        <td>2012/12/12</td>
                                        <td>2012/12/12</td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="action" id="acition" />
                        </form>
                    </div>
                    <div class="row-fluid pagination pagination-right">
                        <ul>
                            <li><a href="#">Prev</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">Next</a></li>
                        </ul>
                    </div>
                    <!-- Form-->
                    <div class="row-fluid">
                        <form action="" method="post" >
                            <legend>Username</legend>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Username</label>
                                <div class="controls">
                                    <input type="text" id="inputWarning" placeholder="Username">                                    
                                    <span class="help-inline">Something may have gone wrong</span>
                                    <em class="help-block">Something may have gone wrong</em>
                                </div>
                            </div>
                            <div class="control-group error">
                                <label class="control-label" for="inputError">Password</label>
                                <div class="controls">
                                    <input type="password" id="inputError" placeholder="Password">
                                    <span class="help-inline">Please correct the error</span>
                                </div>
                            </div>
                            <div class="control-group success">
                                <label class="control-label" for="inputSuccess">Email</label>
                                <div class="controls">
                                    <input type="email" id="inputSuccess" placeholder="Email">
                                    <span class="help-inline">Woohoo!</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" >Phone</label>
                                <div class="controls">
                                    <input type="tel" placeholder="Phone">
                                    <span class="help-inline">Phone Number</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" >Address</label>
                                <div class="controls">
                                    <textarea class="span4" rows="5" placeholder="Address"></textarea>
                                    <span class="help-inline">Phone Number</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" >ID Card</label>
                                <div class="controls">
                                    <input type="text" placeholder="ID Card">
                                    <span class="help-inline">Please input ID Card</span>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="submit" onclick="user_view.doAction()" class="btn btn-primary">Save changes</button>
                                <button type="button" class="btn">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- End form -->
                </div>
            </div>              
        </div>
    </body>
</html>
<script type="text/javascript">
    var user_view = {
        doAction : function(){
          alert("Submit button!");  
        },
        
        submitForm : function (elm,action){
            var $this = $(elm);
            $this.parents("form").select("#action").val(action);
            $this.parents("form").submit();
        }
    }
</script>
