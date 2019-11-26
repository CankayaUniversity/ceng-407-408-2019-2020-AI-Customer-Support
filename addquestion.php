<?php 
include 'header.php';
include 'inc/config.php';
?>

    <body>

        <div class="search-area-wrapper">
            <div class="search-area container">
                <h3 class="search-header">Have a Question?</h3>
                <p class="search-tag-line">If you have any question you can ask below or enter what you are looking!</p>

                <form id="search-form" class="search-form clearfix" method="get" action="#" autocomplete="off">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search this blog">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div id="search-error-container"></div>
                </form>
            </div>
        </div>
        <div class="page-container">
            <div class="container">
                <div class="row">
                    <div class="span8 page-content">
                        <div class="row separator">
                            <section class="span8 articles-list">
                                <div class="my-3 p-3 rounded box-shadow">
                                    <div class="title">
                                        <h3>Add a new question!</h3>
                                    </div>

                                    <div id="editparent">
                                        <div id="editControls">
                                            <div class="btn-group">
                                                <a class="btn btn-xs btn-default" data-role="undo" href="#" title="Undo"><i class="fa fa-undo"></i></a>
                                                <a class="btn btn-xs btn-default" data-role="redo" href="#" title="Redo"><i class="fa fa-repeat"></i></a>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn btn-xs btn-default" data-role="bold" href="#" title="Bold"><i class="fa fa-bold"></i></a>
                                                <a class="btn btn-xs btn-default" data-role="italic" href="#" title="Italic"><i class="fa fa-italic"></i></a>
                                                <a class="btn btn-xs btn-default" data-role="underline" href="#" title="Underline"><i class="fa fa-underline"></i></a>
                                                <a class="btn btn-xs btn-default" data-role="strikeThrough" href="#" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn btn-xs btn-default" data-role="indent" href="#" title="Blockquote"><i class="fa fa-indent"></i></a>
                                                <a class="btn btn-xs btn-default" data-role="insertUnorderedList" href="#" title="Unordered List"><i class="fa fa-list-ul"></i></a>
                                                <a class="btn btn-xs btn-default" data-role="insertOrderedList" href="#" title="Ordered List"><i class="fa fa-list-ol"></i></a>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn btn-xs btn-default" data-role="h1" href="#" title="Heading 1"><i class="fa fa-header"></i><sup>1</sup></a>
                                                <a class="btn btn-xs btn-default" data-role="h2" href="#" title="Heading 2"><i class="fa fa-header"></i><sup>2</sup></a>
                                                <a class="btn btn-xs btn-default" data-role="h3" href="#" title="Heading 3"><i class="fa fa-header"></i><sup>3</sup></a>
                                                <a class="btn btn-xs btn-default" data-role="p" href="#" title="Paragraph"><i class="fa fa-paragraph"></i></a>
                                            </div>
                                        </div>
                                        <div id="editor" contenteditable></div>
                                        <textarea name="ticketDesc" id="editorCopy" required="required" style="display:none;"></textarea>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <?php include "sidebar.php";?>
                </div>
            </div>
        </div>
        <?php include "footer.php";?>