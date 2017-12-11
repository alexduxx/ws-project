<?php

class File
{
    private $_db;
    private $_allFileComments;


    public function __construct()
    {
        $this->_db = DB::getInstance();


    }

    public function addToDb($userId, $pathToFile, $filename, $protected = true)
    {
        if (!$this->fileExists($filename, $userId)) {
            if (!$protected) {
                $protected = 0;
            } else {
                $protected = 1;
            }

            $this->_db->insert('files', array(
                'user_id' => $userId,
                'path_to_file' => $pathToFile,
                'file_name' => $filename,
                'protected' => $protected
            ));

            return true;
        }

        return false;
    }


    public function getUserFiles($userId)
    {
        $files = $this->_db->get('files', array('user_id', '=', $userId));
        $files = $files->results();

        if ($files) {

            foreach ($files as $file) {
                $path_info = explode("/", $file->path_to_file);


                echo "
                    <tr>
                        <td>$file->file_name</td>
                        <td>$file->created_at</td>
                        <td>
                            <a class='comments_link' data-target='#CommentModal' data-toggle='modal' href='#' data-file_id='$file->id'>Comments</a>
                             | <a href='$file->path_to_file' download='$file->file_name'>Download</a>
                             | <a href='files.php?deleteFile=$path_info[1]' >Delete</a> 
                             | <a href='#' class='shareable-link' data-link='http://localhost/2ndSemV2/ws-project/sharedFile.php?x=$path_info[1]'>Copy shareable link</a>
                        </td>
                    </tr>
                 ";


            }


        }


    }

    public function deleteFile($pathToFile)
    {
        $fileToDelete = '1files/' . $pathToFile;
        $this->_db->delete('files', array('path_to_file', '=', $fileToDelete));

        unlink($fileToDelete);

        return true;

    }


    public function fileExists($filename, $userId)
    {

        $file = $this->_db->get('files', array('file_name', '=', $filename));

//        $userFile = $this->_db->get('files', array('user_id', '=', $user));
        if (!$file->count()) {

            return false;
        } else {
            $results = $file->first();
            if ($results->user_id == $userId) {
                return true;
            }
        }

    }

    public function addComment($fileId, $comment, $userId)
    {
        $this->_db->insert('comments', array(
            'file_id' => $fileId,
            'user_id' => $userId,
            'body' => $comment
        ));

        return true;
    }


    public function getFileComments($fileId)
    {
        $comments = $this->_db->get('comments', array('file_id', '=', $fileId));
        $this->_allFileComments = $comments->results();


        return $this->_allFileComments;
    }




}


?>