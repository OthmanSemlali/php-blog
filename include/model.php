

<?php
require_once('include/config.php');



// Class Connection with Data Base
class connect_data_base
{
    protected $connectDB;



    function __construct()
    {


        try {

            $this->connectDB = new PDO('mysql:host=localhost;dbname=***db_name', '***db_user', '***db_pass');
            $this->connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connectDB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('ERROR: could not connect' . $e->getMessage());
        }
    }
}



class mails extends connect_data_base
{

    public function __construct()
    {

        parent::__construct();
    }


    public function add($email)
    {
        $sql = 'INSERT into emails(email) values (:email)';

        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue('email', $email);

        $res = $stmt->execute();


        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}

class messages extends connect_data_base
{

    public function __construct()
    {

        parent::__construct();
    }


    public function add($fullname, $email, $message, $date)
    {
        $sql = 'INSERT into messages(fullname,email,message,date) values (:fullname,:email,:message,"' . $date . '")';

        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':fullname', $fullname);
        $stmt->bindValue(':message', $message);


        $res = $stmt->execute();


        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
// Class posts qui hérite la conextion db
class postsData extends connect_data_base
{

    public function __construct()
    {

        parent::__construct();
    }

    // & use it in post.php table (read 5 record)
    public function read($searchQyery = null)
    {

        if ($searchQyery) {
            $sql = "SELECT * from post WHERE id = '$searchQyery' limit 1";
        } else {
            $sql = "SELECT * from post order dateTime desc limit 5";
        }
        $res = $this->connectDB->query($sql);
        return $res;
    }
    public function readPostForPostPage()
    {


        $sql = "SELECT * from post order by id desc limit 10";

        $res = $this->connectDB->query($sql);
        return $res;
    }


    public function topPostByComments()
    {
        $sql = "SELECT p.* , count(c.id) as 'nb_comments' from post p, comments c where p.id = c.idPost group by p.id order by nb_comments desc limit 0,5 ";
        $res = $this->connectDB->query($sql);

        if ($res->rowCount() > 0) {
            return $res;
        } else {
            return false;
        }
    }

    public function selectPosts($search = null)
    {


        if ($search) {
            $sql = "SELECT * from post where title like :search or category like :search  or bookAuthor like :search order by dateTime desc";


            $stmt = $this->connectDB->prepare($sql);
            $stmt->bindValue(':search', '%' . $search . '%');
        } else {

            // day(dateTime) desc, month(dateTime) desc, dateTime desc, year(dateTime) desc
            $sql = "SELECT * from post order by dateTime desc limit 0,5";
            $stmt = $this->connectDB->prepare($sql);
        }


        $stmt->execute();

        return $stmt;
    }

    // for search bare:
    public function search_bar($search)
    {

        $sql = "SELECT * from post where title like :search or category like :search  or bookAuthor like :search order by dateTime desc";

        $stmt = $this->connectDB->prepare($sql);
        $stmt->bindValue(':search', '%' . $search . '%');
        $stmt->execute();

        return $stmt;
    }


    public function getPostsByCategory($cat)
    {
        $sql = "SELECT * from post where category = :category order by dateTime desc ";
        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':category', $cat);
        $stmt->execute();

        return $stmt;
    }
    public function getPostsBySubCategory($cat, $sub_cat)
    {
        $sql = "SELECT * from post where category = :category and sub_category = :sub order by year(dateTime) desc, day(dateTime) desc ";
        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':category', $cat);
        $stmt->bindValue(':sub', $sub_cat);
        $stmt->execute();

        return $stmt;
    }

    public function getPostsByAuthor($author)
    {
        $sql = "SELECT * from post where bookAuthor = :author order by dateTime desc limit 0,5";
        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':category', $author);
        $stmt->execute();

        return $stmt;
    }

    public function totalPost()
    {

        $sql = "SELECT count(*) from post";
        $stmt = $this->connectDB->query($sql);
        $totalRows = $stmt->fetch();
        // we can't show our array in form of strting

        $totalPosts = array_shift($totalRows);
        return $totalPosts;
    }

    public function totalPostByCategory($category)
    {
        $sql = "SELECT count(*) from post where category = '" . $category . "'";
        $stmt = $this->connectDB->query($sql);
        $totalRows = $stmt->fetch();
        // we can't show our array in form of strting

        $totalPosts = array_shift($totalRows);
        return $totalPosts;
    }

    //load posts in Homepage & use it in pagination table post.php
    public function showPostFrom($From, $record_per_page = null)
    {
        $sql = "SELECT * from post order by dateTime desc limit $From,5";
        if ($record_per_page) {
            $sql = "SELECT * from post order by id desc limit $From,$record_per_page";
        }
        $stmt = $this->connectDB->query($sql);
        return $stmt;
    }

    // Check if the post exist in db or not (in case user enter in url bad ID)
    public function isThere($idPost)
    {
        $sql = "SELECT * from post where id=$idPost";
        $res = $this->connectDB->query($sql);
        if ($res->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }


    public function suggestion()
    {
        $sql = "SELECT * FROM post order by rand() limit 0,6";
        $stmt = $this->connectDB->query($sql);

        return $stmt;
    }
}

// *****************************************
class commentsData extends connect_data_base
{

    public function __construct()
    {

        parent::__construct();
    }


    public function read($idPost)
    {

        $sql = "SELECT * from comments where idPost = $idPost";

        $res = $this->connectDB->query($sql);
        return $res;
    }

    public function read_with_id_comment($id_comment)
    {
        $sql = "SELECT * from comments where id = $id_comment";


        $res = $this->connectDB->query($sql);
        return $res;
    }

    public function showComments($idPost)
    {
        $sql = "SELECT * from comments where idPost = '$idPost' order by id asc limit 0,2";
        $res = $this->connectDB->query($sql);
        // return $res;

        if ($res->rowCount() > 0) {
            return $res;
        } else {
            return false;
        }
    }
    public function showMoreComment($idPost, $from)
    {
        $sql = "SELECT * FROM comments where idPost = $idPost and id > $from limit 2";
        $res = $this->connectDB->query($sql);
        return $res;
    }


    public function count_comments($idPost, $last_id = null)
    {
        $sql = "SELECT count(id) from comments WHERE idPost = $idPost";
        if ($last_id) {
            $sql .= " and id > $last_id";
        }

        $stmt = $this->connectDB->query($sql);
        $res = $stmt->fetch();
        $count = array_shift($res) - 2;
        return $count;
    }

    public function addComment($date, $name, $comment, $idPost)
    {
        // pdo named parameter
        $sql = "INSERT INTO comments(dateTime, nameUser,  comment, idPost) values(:dateTime, :nameUser, :comment, :idPost)";
        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':dateTime', $date);
        $stmt->bindValue(':nameUser', $name);

        $stmt->bindValue(':comment', $comment);
        $stmt->bindValue(':idPost', $idPost);

        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function totalComments($id)
    {

        $sql = "SELECT count(c.id) from comments c, post p where c.idPost = p.id and p.id = $id";
        $stmt = $this->connectDB->query($sql);
        $totalRows = $stmt->fetch();
        // we can't show our array in form of strting

        $totalComments = array_shift($totalRows);
        return $totalComments;
    }
}

// ****************************************
class adminsData extends connect_data_base
{

    public function __construct()
    {

        parent::__construct();
    }


    

}

class left_side extends connect_data_base
{
    public function __construct()
    {
        parent::__construct();
    }



    public function read()
    {
        $sql = "SELECT * from left_side order by id desc limit 1";
        $stmt = $this->connectDB->query($sql);
        return $stmt;
    }
}

// *******************************************


class subcategoryData extends connect_data_base
{
    public function __construct()
    {

        parent::__construct();
    }

 

    public function displaySubCategoriesOfCategory($category_id)
    {
        $sql = "SELECT * from sub_categories where category_id=$category_id  ";
        $stmt = $this->connectDB->query($sql);
        return $stmt;
    }

    public function readSubCategory($sub_cat, $category_id)
    {
        $sql = "SELECT description from sub_categories where name='$sub_cat' and category_id=$category_id";
        $stmt = $this->connectDB->query($sql);

        return $stmt;
    }

   
}
class categoriesData extends connect_data_base
{
    public function __construct()
    {

        parent::__construct();
    }

    public function readCategory($category = null)
    {
        $sql = "select * from category";
        if ($category) {
            $sql .= " where title='$category'";
        }
        $res = $this->connectDB->query($sql);
        return $res;
    }
    public function getCategoryId($category)
    {
        $sql = "select id from category where title='$category'";
        $res = $this->connectDB->query($sql);
        $id = $res->fetch();
        // we can't show our array in form of strting

        $id = array_shift($id);
        return $id;
    }



    public function getCategories()
    {

        

        $sql = "SELECT c.title as category, s.name as subcategory
        FROM category c
        LEFT JOIN sub_categories s ON c.id = s.category_id
        where c.title in (select category from post)
        ORDER BY c.title, s.name";
        $stmt = $this->connectDB->query($sql);

        return $stmt;
    }
}

// Objects

$category = new categoriesData();
$subcategory = new subcategoryData();
$posts = new postsData();
$admin = new adminsData();

$com = new commentsData();
$side_left = new left_side();


$mails = new mails();
$messages = new messages();
