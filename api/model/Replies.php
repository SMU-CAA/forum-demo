<?php
require_once __DIR__ . "/../model/Model.php";

class Replies extends Model
{

    protected $create_string = "CREATE TABLE IF NOT EXISTS replies (
                                   reply_id serial NOT NULL PRIMARY KEY,
                                   user_id serial NOT NULL REFERENCES users,
                                   thread_id serial NOT NULL REFERENCES threads,
                                   reply_content text NOT NULL,
                                   reply_time timestamp NOT NULL,
                                   reply_visible boolean NOT NULL DEFAULT TRUE,
                                   reply_is_reply boolean NOT NULL DEFAULT FALSE,
                                   reply_reply_id integer REFERENCES replies (reply_id) DEFAULT NULL
                                 );";

    public function reply($reply)
    {
        if (isset($reply)) {
            /**
             * @var int $user_id
             * @var int $thread_id
             * @var int $reply_id
             * @var string $reply_content
             * @var string $reply_time
             */
            extract($reply);
            if (isset($reply_id)) {
                $reply_query = "INSERT INTO replies (user_id, thread_id, reply_content, reply_time, reply_is_reply, reply_reply_id)
                                VALUES ('$user_id', '$thread_id', '$reply_content', '$reply_time', TRUE, '$reply_id')";
            } else {
                $reply_query = "INSERT INTO replies (user_id, thread_id, reply_content, reply_time)
                                VALUES ('$user_id', '$thread_id', '$reply_content', '$reply_time')";
            }
            return pg_query($this->connection, $reply_query) ? true : false;
        } else
            return false;
    }

    public function search($search)
    {
        if (isset($search))
            return pg_fetch_all(pg_query("SELECT * FROM replies WHERE reply_content LIKE '%$search%'"));
        else
            return null;
    }

    public function delete($reply_id)
    {
        $delete_query = "UPDATE replies SET reply_visible = FALSE WHERE reply_id='$reply_id'";
        return pg_query($this->connection, $delete_query) ? true : false;
    }

    public function selectAll($reply_id)
    {
        if (isset($reply_id)) {
            $result = pg_fetch_assoc(pg_query($this->connection, "SELECT * FROM replies WHERE reply_id='$reply_id'"));
            return ($result) ? $result : null;
        } else
            return null;
    }

}
