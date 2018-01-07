</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="js/master.js"></script>

<?php

if (isset($_GET['deleteFile'])) {
    ?>
    <script type="text/javascript">
        $('#confirmFileDeleteModal').modal('show');
    </script>
<?php } ?>

<script>


    $(document).on("click", ".comments_link", function () {
        var fileId = $(this).data("file_id");
        $("#comment-form").attr('action', 'addComment.php?file_id=' + fileId + '');

        $.ajax({
            "url": "getComments.php",
            "method": "POST",
            "cache": "false",
            "data": {file: fileId}
        }).done(function (comments) {
            console.log(comments);
            for (i = 0; i < comments.length; i++) {
                console.log(comments[i].commentBody);
            }


            var container = $('.comments-container');
            container = container.html("");

            var commentTemplate = ' <div class="row comment-container">\
                                       <div class="username">\
                                           <b>{{username}}</b>\
                                       </div>\
                                       <div class="date container">\
                                           <i>{{date}}</i>\
                                       </div>\
                                       <div class="comment-container">\
                                           <span>{{body}}</span>\
                                       </div>\
                                    </div>';

            for (var i = 0; i < comments.length; i++) {
                template = commentTemplate.replace("{{username}}", comments[i].username).replace("{{date}}", comments[i].commentDate).replace("{{body}}", comments[i].commentBody);

                container.append(template);
            }

        });


    });

</script>

</body>
</html>
