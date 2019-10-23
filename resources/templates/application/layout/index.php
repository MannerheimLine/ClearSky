<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ru">
    <head>
        <link rel="stylesheet" type="text/css" href="/resources/assets/bootstrap/css/bootstrap.css"/>
        <!--<link rel="stylesheet" type="text/css" href="/resources/assets/fontawesome/css/font-awesome.min.css"/>-->
        <link rel="stylesheet" type="text/css" href="/resources/assets/fontawesome-free/css/all.css"/>
        <link rel="stylesheet" type="text/css" href="/resources/templates/application/layout/css/style.css"/>
        <script type="application/javascript" src="/resources/assets/jquery/jquery-3.4.1.min.js"></script>
        <script type="application/javascript" src="/resources/templates/application/layout/js/application.js"></script>
        <title id="title"><?=$this->_title?></title>
    </head>
    <body>
    <div id="wrapper">
        <section id="header_section"></section>
        <section id="main_section">
            <section id="sidebar_section"></section>
            <section id="content_section">
                <?php include $this->_pagesFolder.$page.'.php'; ?>
            </section>
        </section>
        <section id="footer_section"></section>
    </div>
    <script type="application/javascript" src="/resources/assets/jquery/jquery-3.4.1.min.js"></script>
    <script type="application/javascript" src="/resources/assets/bootstrap/js/bootstrap.js"></script>
    </body>
</html>
