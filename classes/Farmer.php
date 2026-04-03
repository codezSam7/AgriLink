<?php

require_once 'Db.php';
class Farmer extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
    }

    public function fetch_all_states()
    {
        $sql = 'SELECT * FROM state';
        $stmt = $this->agconn->prepare($sql);
        $stmt->execute();
        $rsp = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rsp;
    }

    public function fetch_lga($state_id)
    {
        $sql = 'SELECT * FROM lga WHERE state_id = ?';
        $stmt = $this->agconn->prepare($sql);
        $stmt->execute([$state_id]);
        $rsp = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rsp;
    }

    public function state_exists($state_id)
    {
        $stmt = $this->agconn->prepare('SELECT 1 FROM state WHERE state_id = ? LIMIT 1');
        $stmt->execute([$state_id]);
        $rsp = $stmt->fetchColumn();

        return $rsp;
    }

    public function lga_exists_for_state($lga_id, $state_id)
    {
        $stmt = $this->agconn->prepare('SELECT 1 FROM lga WHERE lga_id = ? AND state_id = ? LIMIT 1');
        $stmt->execute([$lga_id, $state_id]);
        $rsp = $stmt->fetchColumn();

        return $rsp;
    }

    public function register_farmer($fulln, $farmn, $phone, $email, $password, $primary, $bio, $state_id, $lga_id)
    {
        try {
            // validate state and lga
            if (! $this->state_exists($state_id)) {
                // invalid state
                return false;
            }
            if (! $this->lga_exists_for_state($lga_id, $state_id)) {
                // invalid lga for that state
                return false;
            }

            $sql = 'INSERT INTO farmers(
                farmer_fullname,
                farmer_farm_name,
                farmer_phone,
                farmer_email,
                farmer_password_hash,
                farmer_primary_produce,
                farmer_bio,
                farmer_state_id,
                farmer_lga_id) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->agconn->prepare($sql);
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([$fulln, $farmn, $phone, $email, $hashed, $primary, $bio, $state_id, $lga_id]);
            $regfarmer = $this->agconn->lastInsertId();

            return $regfarmer;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;

            return false;
        }
    }

    public function login_farmer($email, $password)
    {
        try {
            $sql = 'SELECT * FROM farmers WHERE farmer_email = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$email]);
            $frecord = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($frecord) {
                $saved_hash = $frecord['farmer_password_hash'];
                $frsp = password_verify($password, $saved_hash);
                if ($frsp) {
                    // keep their id in session: key:user_online
                    $_SESSION['farmer_online'] = $frecord['farmer_id'];

                    return true; // password and username are correct
                } else {
                    $_SESSION['errormsg'] = 'Incorrect password';

                    return false; // incorrect password
                }
            } else {
                $_SESSION['errormsg'] = 'Invalid username';

                return false;
            }
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function fetch_farmers()
    {
        try {
            $sql = 'SELECT f.*, s.state_name 
                    FROM farmers f 
                    JOIN state s ON f.farmer_state_id = s.state_id';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute();
            $farmers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $farmers;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function get_farmer_details($farmer_id)
    {
        $sql = "SELECT * FROM farmers WHERE farmer_id = :id";
        $stmt = $this->agconn->prepare($sql);
        $stmt->bindValue(':id', $farmer_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add_product($pname, $farmer_id, $category_id, $pdesc, $punit, $pprice, $pqtyav, $pimage)
    {
        try {
            $sql = 'INSERT INTO products(product_name,product_farmer_id,product_category_id,product_description,product_unit,product_price,product_quantityavailable,product_image) VALUES(?,?,?,?,?,?,?,?)';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$pname, $farmer_id, $category_id, $pdesc, $punit, $pprice, $pqtyav, $pimage]);
            $rsp = $this->agconn->lastInsertId();

            return $rsp;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function upload_file($fileerror, $filesize, $filename, $filetmp)
    {
        try {
            // check if there is error
            if ($fileerror > 0) {
                $_SESSION['errormsg'] = 'Error uploading your file, please try agian later';

                return false;
            }

            // someone uploading a wrong file type
            $ext_accepted = ['jpeg', 'jpg', 'png'];
            // explode the user filename and extract their extension
            $fileinfo_array = explode('.', $filename);
            $user_ext = strtolower(end($fileinfo_array));
            // check if the extension of the user that you extract is not in the list of what you accepted
            if (! in_array($user_ext, $ext_accepted)) {
                $_SESSION['errormsg'] = 'Only image with extension png, jpeg, jpg are excepted, upload an acceptable file type';

                return false;
            }
            // someone uploading a file size that is too big: scenario here is if it's greater than 2mb=> 2*1024*1024
            if ($filesize > 2097152) {
                $_SESSION['errormsg'] = 'File too big, upload an image below 2mb';

                return false;
            }
            // generating a uniq filename for the file
            $unique_filename = 'agri' . '_' . time() . '_' . uniqid() . ".$user_ext";
            // upload it: move it from tmp location to permanent space
            $response = move_uploaded_file($filetmp, "../uploads/$unique_filename");

            return $unique_filename;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function update_profile($fullname, $farmname, $phone, $bio, $farmer_id, $filename = '')
    {
        // echo "f: $fullname, bio: $bio, user_id: $user_id, filename: $filename";
        // exit;
        try {
            if (empty($filename)) {
                $sql = 'UPDATE farmers set farmer_fullname = ?, farmer_farm_name = ?, farmer_phone = ?, farmer_bio = ?  WHERE farmer_id = ?';
            } else {
                $sql = 'UPDATE farmers set farmer_fullname = ?, farmer_farm_name = ?, farmer_phone = ?, farmer_bio = ?, farmer_avatarurl = ? WHERE farmer_id = ?';
            }
            $stmt = $this->agconn->prepare($sql);
            $res = $stmt->execute([$fullname, $farmname, $phone, $bio, $filename, $farmer_id]);

            return $res;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();

            return false;
        }
    }

    public function fetch_products()
    {
        try {
            $sql = 'SELECT *,product_id as pid, product_description as pdesc FROM products JOIN categories ON product_category_id=category_id JOIN farmers ON product_farmer_id=farmer_id JOIN state ON farmer_state_id = state_id';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $products;
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function fetch_farmer_products($farmer_id)
    {
        $sql = "SELECT p.*, f.farmer_fullname 
            FROM products p 
            JOIN farmers f ON p.product_farmer_id = f.farmer_id 
            WHERE p.product_farmer_id = ? 
            ORDER BY p.product_id DESC";

        $stmt = $this->agconn->prepare($sql);
        $stmt->execute([$farmer_id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    public function search_farmers($search = '', $state_id = null, $lga_id = null)
    {
        try {
            $sql = 'SELECT f.*, s.state_name
                    FROM farmers f
                    JOIN state s ON f.farmer_state_id = s.state_id';
            $where = [];
            $params = [];

            // Search term
            if (! empty($search)) {
                $like = '%' . $search . '%';
                $where[] = '(f.farmer_fullname LIKE ? OR f.farmer_farm_name LIKE ? OR f.farmer_primary_produce LIKE ? OR f.farmer_phone LIKE ? OR f.farmer_email LIKE ?)';
                // push the same like placeholder for each field
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
            }

            // State filter (validate if provided)
            if (! empty($state_id)) {
                if (! $this->state_exists($state_id)) {
                    return []; // invalid state => no results
                }
                $where[] = 'f.farmer_state_id = ?';
                $params[] = $state_id;
            }

            // LGA filter (validate if provided)
            if (! empty($lga_id)) {
                if (! empty($state_id)) {
                    // validate lga belongs to state
                    if (! $this->lga_exists_for_state($lga_id, $state_id)) {
                        return []; // invalid lga for the given state
                    }
                } else {
                    // validate lga exists (no state provided)
                    $chk = $this->agconn->prepare('SELECT 1 FROM lga WHERE lga_id = ? LIMIT 1');
                    $chk->execute([$lga_id]);
                    if (! $chk->fetchColumn()) {
                        return []; // invalid lga
                    }
                }
                $where[] = 'f.farmer_lga_id = ?';
                $params[] = $lga_id;
            }

            if (! empty($where)) {
                $sql .= ' WHERE ' . implode(' AND ', $where);
            }

            $stmt = $this->agconn->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function get_product_by_id($id)
    {
        try {
            $sql = 'SELECT 
                    p.*, 
                    f.farmer_fullname, 
                    s.state_name 
                FROM products p
                JOIN farmers f ON p.product_farmer_id = f.farmer_id
                JOIN state s ON f.farmer_state_id = s.state_id
                WHERE p.product_id = ?';

            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            return $product ? $product : false;
        } catch (PDOException $e) {
            // You can log this error to a file instead of echoing in production
            // echo $e->getMessage(); die();
            return false;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }
}
