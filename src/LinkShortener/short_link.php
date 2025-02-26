<?php
    include("includes/db.php");
    session_start();

    if (!isset($_SESSION['user_id'])) 
    {
        header("Location: accedi.html");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $user_id = $_SESSION["user_id"];
        $link = $_POST["link"];

        $hash = md5($link);
        $shorted_link = "https://3000-idx-docker-xampp-1736234929524.cluster-6yqpn75caneccvva7hjo4uejgk.cloudworkstations.dev/LinkShortener/links/" . $hash;
        
        $content = 
"<?php
    include('../includes/db.php');
    session_start();

    \$query = \"update links set visite = visite + 1 where original_link = '$link';\";
    \$result = \$conn->query(\$query);

    header(\"Location: $link\");
    exit;
?>"; // Contenuto da scrivere nel file
        
        file_put_contents("links/$hash", $content);

        $query = "insert into links (original_link, shorted_link, user_id) values ('$link', '$shorted_link', $user_id)";
        
        if($conn->query($query))
            echo "success";
        else
            echo "error";
    } 

?>