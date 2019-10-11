<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <!--<link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap.css"/>-->
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <!--<script type="application/javascript" src="/resources/assets/jquery/jquery-3.4.1.min.js"></script>
        <script type="application/javascript" src="/resources/assets/bootstrap/js/bootstrap.js"></script>
        <script type="application/javascript" src="js/application.js"></script>-->
        <title id="title"><?=$this->_title?></title>
    </head>
    <body>
    <div id="wrapper">
        <section id="header_section"></section>
        <section id="content_section">
            <div>
                <?php include $this->_pagesFolder.$page.'.php'; ?>
            </div>
        </section>
        <section id="footer_section"></section>
    </div>
    </body>
</html>
