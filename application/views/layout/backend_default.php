<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $app_page_title;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Default JS -->
        <?php if(isset($app_a_default_js) && !empty($app_a_default_js)){ 
            foreach($app_a_default_js as $item){ ?>
                <script type="text/javascript" src="<?php echo $app_base_url;?>asset/public/js/<?php echo $item;?>.js"></script>
        <?php } }?>
                
        <!-- Library JS -->
        <?php if(isset($app_a_lib_js) &&!empty($app_a_lib_js)){ 
            foreach($app_a_lib_js as $item){ ?>
                <script type="text/javascript" src="<?php echo $app_base_url;?>asset/public/lib/<?php echo $item;?>.js"></script>
        <?php } }?>
                
        <!-- Library CSS -->
        <?php if(isset($app_a_lib_css) && !empty($app_a_lib_css)){ 
            foreach($app_a_lib_css as $item){ ?>
                <link href="<?php echo $app_base_url;?>asset/public/lib/<?php echo $item;?>.css" rel="stylesheet" >
        <?php } }?>               
                
        <!-- Backend end JS -->
        <?php if(isset($app_a_backend_js) && !empty($app_a_backend_js)){ 
            foreach($app_a_backend_js as $item){ ?>
                <script type="text/javascript" src="<?php echo $app_base_url;?>asset/backend/js/<?php echo $item;?>.js"></script>
        <?php } }?>  
                
        <!-- Backend end CSS -->    
        <?php if(isset($app_a_backend_css) && !empty($app_a_backend_css)){ 
            foreach($app_a_backend_css as $item){ ?>
                <link href="<?php echo $app_base_url;?>asset/backend/css/<?php echo $item;?>.css" rel="stylesheet" >
        <?php } }?>   
                    
       <!-- Bootstrap -->        
        <script type="text/javascript" src="<?php echo $app_base_url;?>bootstrap/js/bootstrap.min.js"></script>                    
        <link href="<?php echo $app_base_url;?>bootstrap/css/bootstrap.min.css" rel="stylesheet" >       
        <link href="<?php echo $app_base_url;?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" >         
     
        <!-- Default CSS -->
        <?php if(isset($app_a_default_css) && !empty($app_a_default_css)){ 
            foreach($app_a_default_css as $item){ ?>
                <link href="<?php echo $app_base_url;?>asset/public/css/<?php echo $item;?>.css" rel="stylesheet" >
        <?php } }?>
                
    </head>
    
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <?php echo $this->load->view("backend/elements/top_menu");?>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                
                <!-- Right Content -->
                <div class="span12">
                    <!-- Bread Crumb -->
                    <div class="row-fluid">
                        <ul class="breadcrumb">
                            <li><a href="#">Home</a> <span class="divider">/</span></li>
                            <li><a href="#">Library</a> <span class="divider">/</span></li>
                            <li class="active">Data</li>
                        </ul>
                    </div>
                    
                    <?php echo $app_content_for_layout;?>
                    
                </div>
            </div>              
        </div>
    </body>
</html>
