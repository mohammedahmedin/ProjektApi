 <?php
class User {
    private $database_connection;

   function __construct($db) {
      $this->database_connection = $db;
   }
        
   function CreateUser($userName_IN, $useremail_IN, $userPassword_IN) {
      if(!empty($userName_IN) && !empty($useremail_IN) && !empty($userPassword_IN)) {

      $sql ="SELECT UsersId FROM users WHERE UserName=:userName_IN OR Useremail=:useremail_IN";
         $statement = $this->database_connection->prepare($sql);
         $statement->bindParam(":userName_IN", $userName_IN);
         $statement->bindParam(":useremail_IN", $useremail_IN);
            
         if(!$statement->execute()){
            echo "Could not execute query!";
            die();
         }

         $num_rows = $statement->rowCount();

         if($num_rows > 0) {
               echo "The user already registered!";
               die();
         } else {

            $sql ="INSERT INTO users (UserName, Useremail, UserPassword) 
            VALUES (:userName_IN, :useremail_IN, :password)";
            $statement = $this->database_connection->prepare($sql);
            $statement->bindParam(":userName_IN", $userName_IN);
            $statement->bindParam(":useremail_IN", $useremail_IN);

            $hashed_password = password_hash($userPassword_IN, PASSWORD_DEFAULT);
            $statement->bindParam(":password", $hashed_password);
            
            if($statement->execute()) {
               echo "User created";
            } else {
               echo "Something went wrong";
            }
         }
      } else {
         echo "All fields required";
      }
   }
  
   function GetAllUsers() {
      $sql = "SELECT UserName, Useremail, UserPassword FROM users";
      $statement = $this->database_connection->prepare($sql);
      $statement->execute();
      
      while($row = $statement->fetch())  {
         echo $row['UserName'] . " " . $row['Useremail'] . " " . $row['UserPassword'];
      }
   }

   function updateUser($query, $username, $email, $password, $user_id){
      $stm = $this->database_connection->prepare("UPDATE users SET $query WHERE UsersId = :user_id");
      $stm->bindParam(":user_id", $user_id);
      
      if($username != false) {
         $stm->bindParam(":username", $username);
      }

      if($email != false) {
         $stm->bindParam(":email", $email);
      }

      if($password != false) {
         $hash_password = password_hash($password, PASSWORD_DEFAULT);
         $stm->bindParam(":password", $hash_password);
      }

      if($stm->execute()){
         echo "User id $user_id has been updated.";
      } else {
         echo "Something went wrong";
      }
   }

   function deleteUser($user_id){
      $stm = $this->database_connection->prepare("DELETE FROM users WHERE UsersId = :user_id");
      $stm->bindParam(":user_id", $user_id);

      if($stm->execute()){
         echo "Successfully deleted User Id $user_id";
      } else {
         echo "Something went wrong";
      }
   }
}