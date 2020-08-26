<div class="mt-5 text-white">
    <div class="row">
        <div class="col-md-4">
            <div class="ml-5">
                <h1>Add post</h1>
                <?php

                    if ( isset($_SESSION['user_login']) )
                    {
                        $html = <<<EOT
                        <form action="/main/add" method="POST" class="form">
                            <div class="form-group">
                                <label for="title_field">Title</label>
                                <input type="text" id="title_field" class="form-control" name="title">
                            </div>
                            <div class="form-group">
                                <label for="content_field">Contents</label>
                                <textarea class="form-control" rows="5" id="content-field" name="content"></textarea>
                            </div> 
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>
                        EOT;
                        echo $html;
                    }
                    else
                    {
                        $html = <<<EOT
                        <div class="alert alert-warning">
                            <strong>Log in or sign up to add post</strong>
                        </div>
                        EOT;
                        echo $html;
                    }

                ?>
            </div>
        </div>

        <div class="col-md-8">
            <div class="ml-5 mr-5">
                <h1>Some other posts</h1>
                <?php

                    if ( isset($post_error) )
                    {
                        $html = <<<EOT
                        <div class="alert alert-danger">
                            <p>$post_error</p>
                        </div>
                        EOT;
                        echo $html;
                    }

                    if ( !empty($posts) )
                    {
                        foreach( $posts as $post )
                        {
                            $title = $post['title'];
                            $content = $post['content'];

                            $html = <<<EOT
                            <div class="card mt-3 text-dark">
                                <div class="card-body">
                                    <h4 class="card-title">$title</h4>
                                    <p class="card-text">$content</p>
                                </div>
                            </div>
                            EOT;
                            echo $html;
                        }
                    }
                    else
                    {
                        $html = <<<EOT
                        <div class="alert alert-info">
                            <p>No posts yet</p>
                        </div>
                        EOT;
                        echo $html;
                    }

                ?>
            </div>
        </div>
    </div>
</div>