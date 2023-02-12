

<?php



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



    public function getCounterOfNewsLetterSubscribers()
    {

        $sql = "SELECT count(*) from emails ";
        $stmt = $this->connectDB->query($sql);
        $totalRows = $stmt->fetch();
        // we can't show our array in form of strting

        $total = array_shift($totalRows);
        return $total;
    }
}

// Class posts qui hérite la conextion db
class postsData extends connect_data_base
{

    public function __construct()
    {

        parent::__construct();
    }

    public function addPost($dateTime, $title, $category, $image, $description, $author, $idAdmin, $bookAuthor, $excerpt, $contents, $seo_description, $subcategory)
    {
        $sql = "INSERT INTO post(dateTime, title, category, image, description, author,idAdmin, bookAuthor,id_author,excerpt,contents,seo_description, sub_category) values(:dateTime, :title, :category, :image, :description, :author, :idAdmin, :bookAuthor,1,:excerpt,:contents,:seo_description,:sub_category)";
        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':dateTime', $dateTime);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':category', $category);
        $stmt->bindValue(':sub_category', $subcategory);
        $stmt->bindValue(':image', $image);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':author', $author);
        $stmt->bindValue(':idAdmin', $idAdmin);
        $stmt->bindValue(':bookAuthor', $bookAuthor);
        $stmt->bindValue(':excerpt', $excerpt);
        $stmt->bindValue(':contents', $contents);
        $stmt->bindValue(':seo_description', $seo_description);


        $res = $stmt->execute();
        if ($res) {
            return true;
        } else {
            return false;
        }
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

    public function delete($searchQyery)
    {
        $sql = "DELETE from post where id=$searchQyery";
        $stmt = $this->connectDB->prepare($sql);
        $res = $stmt->execute();
        if ($res) {


            //Delete file from database
            $sqll = "SELECT * from post WHERE id =$searchQyery ";
            $res = $this->connectDB->query($sqll);

            $r = $res->fetch();

            $file_path = '../upload/' . $r['image'];
            unlink($file_path);


            return true;
        } else {
            return false;
        }
    }


    public function edit($title, $category, $image = null, $description, $author, $idAdmin, $bookAuthor, $excerpt, $contents, $seo_description, $searchQyery)
    {
        // in case if we don't want to change image, then old image should stay
        $sql = "UPDATE post SET  title = :title, category = :cat,   description = :descr, author=:author,idAdmin =:idAdmin, bookAuthor = :bookAuthor, excerpt = :excerpt, contents=:contents, seo_description=:seo_description where id = :searchQyery";
        if ($image) {
            $sql = "UPDATE post SET  title = :title, category = :cat, image = '$image',  description = :descr, author=:author,idAdmin =:idAdmin, bookAuthor = :bookAuthor, excerpt = :excerpt, contents=:contents,seo_description=:seo_description where id = :searchQyery";
        }

        // pdo named parameter
        $stmt = $this->connectDB->prepare($sql);
        $stmt->bindValue(':descr', $description);
        $stmt->bindValue(':title', $title);

        $stmt->bindValue(':cat', $category);
        $stmt->bindValue(':author', $author);
        $stmt->bindValue(':idAdmin', $idAdmin);
        $stmt->bindValue(':bookAuthor', $bookAuthor);
        $stmt->bindValue(':searchQyery', $searchQyery);

        $stmt->bindValue(':excerpt', $excerpt);
        $stmt->bindValue(':contents', $contents);
        $stmt->bindValue(':seo_description', $seo_description);

        $res = $stmt->execute();
        if ($res) {
            return true;
        } else {
            return false;
        }
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


            $sql = "SELECT * from post order by day(dateTime) desc, month(dateTime) desc, dateTime desc, year(dateTime) desc limit 0,5";
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

    // use it in select in post.php

    public function read_until($until)
    {
        $sql = "SELECT * from post order by dateTime desc limit 0,$until";

        $res = $this->connectDB->query($sql);
        return $res;
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


    public function suggestion(){
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


    public function add($date, $userName, $pass1, $fullName, $addedBy, $headLine, $adminBio, $adminImage, $status)
    {
        $sql = "INSERT INTO admin(dateTime, username, password, adminName, added_approved_by, adminHeadLine, adminBio, adminImage, status) values(:dateTime, :username, :password, :adminName, :added_approved_by, :adminHeadLine, :adminBio, :adminImage, :status)";

        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':dateTime', $date);
        $stmt->bindValue(':username', $userName);
        $stmt->bindValue(':password', $pass1);
        $stmt->bindValue(':adminName', $fullName);
        $stmt->bindValue(':added_approved_by', $addedBy);
        $stmt->bindValue(':adminHeadLine', $headLine);
        $stmt->bindValue(':adminBio', $adminBio);
        $stmt->bindValue(':adminImage', $adminImage);
        $stmt->bindValue(':status', $status);

        $res = $stmt->execute();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function existingAdminsExceptManager()
    {
        $sql = "SELECT * from admin where status = 'On' AND username not in ('uthmeene')";
        $res = $this->connectDB->query($sql);
        return $res;
    }

    public function pendingAdmins()
    {
        $sql = "SELECT * from admin where status = 'Off'";
        $res = $this->connectDB->query($sql);
        if ($res->rowCount() > 0) {
            return $res;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $sql = "DELETE from admin where id = $id";
        $res = $this->connectDB->query($sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function confirmAdmin($On, $nameAdConnected, $id_Admin_from_Table_Inscription)
    {
        $sql = "UPDATE admin set status = ? , added_approved_by = ? where id = ?";
        $stmt = $this->connectDB->prepare($sql);
        $res = $stmt->execute([$On, $nameAdConnected, $id_Admin_from_Table_Inscription]);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function checkLogin($user, $pass, $status = null)
    {
        $sql = "SELECT * FROM admin where username= :username and password = :password LIMIT 1";
        // if ($status) {
        //     $sql = "SELECT * FROM admin where username= :username and password = :password and status = '$status' LIMIT 1";
        // }
        $stmt = $this->connectDB->prepare($sql);
        $stmt->bindValue(':username', $user);
        $stmt->bindValue(':password', $pass);

        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            return $stmt;
        } else {
            return false;
        }
    }

    public function createAccount($date, $userName, $pass1, $fullName, $addedBy, $headLine, $adminBio, $adminImage, $status, $email)
    {
        // pdo named parameter
        $sql = "INSERT INTO admin(dateTime, username, password, adminName, added_approved_by, adminHeadLine, adminBio, adminImage, status, email) values(:dateTime, :username, :password, :adminName, :added_approved_by, :adminHeadLine, :adminBio, :adminImage, :status, :email)";

        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':dateTime', $date);
        $stmt->bindValue(':username', $userName);
        $stmt->bindValue(':password', $pass1);
        $stmt->bindValue(':adminName', $fullName);
        $stmt->bindValue(':added_approved_by', $addedBy);
        $stmt->bindValue(':adminHeadLine', $headLine);
        $stmt->bindValue(':adminBio', $adminBio);
        $stmt->bindValue(':adminImage', $adminImage);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':email', $email);

        $res = $stmt->execute();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function totalAdminsNotConfirmed()
    {

        $sql = "SELECT count(*) from admin where status = 'Off'";
        $stmt = $this->connectDB->query($sql);
        $totalRows = $stmt->fetch();
        // we can't show our array in form of strting

        $totalAdmins = array_shift($totalRows);
        return $totalAdmins;
    }

    public function checkUsernameExisting($userName)
    {

        $sql = "SELECT * from `admin` where username = :userName";
        $stmt = $this->connectDB->prepare($sql);
        $stmt->bindValue(':userName', $userName);

        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            return true;
            // return $stmt;
        } else {
            return false;
        }
    }

    public function checkUsername($userName)
    {

        $sql = "SELECT * from `admin` where username = :userName";
        $stmt = $this->connectDB->prepare($sql);
        $stmt->bindValue(':userName', $userName);

        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            // return true;4
            return $stmt;
        } else {
            return false;
        }
    }
}

class left_side extends connect_data_base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($image, $text)
    {

        $sql = "INSERT into left_side(image, text) values (?,?)";



        $stmt = $this->connectDB->prepare($sql);

        $res = $stmt->execute([$image, $text]);

        if ($res) {
            return true;
        } else {
            return false;
        }
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

    public function addSubCategory($name, $description, $category_id)
    {
        $sql = "INSERT INTO sub_categories(name, category_id,description) values(:name,:category_id,:description)";
        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':category_id', $category_id);
        $stmt->bindValue(':description', $description);

        $res = $stmt->execute();
        if ($res) {
            return true;
        } else {
            return false;
        }
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

    public function delete($idSubCategory)
    {
        $sql = "DELETE from sub_categories where id = $idSubCategory";
        $res = $this->connectDB->query($sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
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

    public function addCategory($title, $description, $author)
    {
        $sql = "INSERT INTO category(title, author,description) values(:title,:author,:description)";
        $stmt = $this->connectDB->prepare($sql);

        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':author', $author);
        $stmt->bindValue(':description', $description);

        $res = $stmt->execute();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($idCategory)
    {
        $sql = "DELETE from category where id = $idCategory";
        $res = $this->connectDB->query($sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function totalCategories()
    {

        $sql = "SELECT count(*) from category";
        $stmt = $this->connectDB->query($sql);
        $totalRows = $stmt->fetch();
        // we can't show our array in form of strting
        $totalCategories = array_shift($totalRows);
        return $totalCategories;
    }

    public function getCategories()
    {

        // $sql = "SELECT distinct title from category where title in (select category from post) ORDER BY RAND() limit 5";
        // $stmt = $this->connectDB->query($sql);
        // return $stmt;

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

