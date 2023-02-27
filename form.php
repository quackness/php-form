<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="form.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Globoticket</title>
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto ms-3 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <img src="logo.png" alt="Globoticket logo" />
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Registration Form</h1>
        <?php
        function myHtmlspecialchars($s, $flags = null) {
            if(is_string($s)) {
                return ($flags === null) ?
                htmlspecialchars($s) :
                htmlspecialchars($s, $flags);
            } else {
                return "";

            }
        }
        // htmlspecialchars scrubs the data and ent quotes is a set of data you want to remove from the data you are passing in example ^&&*
        // if(isset($_POST["submit"]) && $_POST["submit"] === "Register") {
            $formComplete = false;

            $password = myHtmlspecialchars($_POST["password"] ?? "", ENT_QUOTES);
            $comments = myHtmlspecialchars($_POST["comments"] ?? "", ENT_QUOTES);
            $customertype = htmlspecialchars($_POST["customertype"] ?? "", ENT_QUOTES);
            $email = myHtmlspecialchars($_POST["email"] ?? "", ENT_QUOTES);
            $tos = myHtmlspecialchars($_POST["tos"] ?? "", ENT_QUOTES);
            $layout = myHtmlspecialchars($_POST["layout"] ?? "", ENT_QUOTES);
            $interestsAsArray = (isset($_POST["interests"]) && is_array($_POST["interests"])) ? $_POST["interests"] : [];
            $interests = myHtmlspecialchars(implode(", ", $interestsAsArray), ENT_QUOTES);
           
            if (isset($_POST["submit"]) && $_POST["submit"] === "Register") {
        
            //implode takes values from the array and glue them together to a string, between those values we will use a comma and a blank
            $formComplete = true;
            $errorMessages = [];
  
            // if (trim($email) === "" || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            //     $formComplete = false;
            // }

            if (trim($email) === "") {
                $formComplete = false;
                array_push($errorMessages, "Email address missing");
            } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $formComplete = false;
                array_push($errorMessages, "Email address is incorrect");
            }

            if (trim($password) === "") {
                $formComplete = false;
                array_push($errorMessages, "Passoword field cannot be blank");
            }
            if (trim($comments) === "") {
                $formComplete = false;
                array_push($errorMessages, "Comments missing");
            }
            if (!in_array($customertype, ["seller", "buyer"])) {
                $formComplete = false;
                array_push($errorMessages, "Customer type missing");
            }
            if ($tos !== "ok") {
                $formComplete = false;
                array_push($errorMessages, "ToS must be accepted");
            }
            if (!in_array($layout, ["dark", "light"])) {
                $formComplete = false;
                array_push($errorMessages, "Layout selection missing");
            }
            if ($interests === "") {
                $formComplete = false;
                array_push($errorMessages, "Interests missing");
            }

            if ($formComplete) {
                echo "<div class=\"mb-3\">Email: $email<br>Password: $password
                <br>Customer type: $customertype<br>Accept TOS: $tos
                <br>Layout: $layout<br>Interests: $interests<br>
                Comments: " . nl2br($comments) ."</div>";
            } else {
                echo "<div class=\"mt-4 mb-3 text-danger\"><p class=\"fw-bold\">Validation errors:</p><ul>";
                foreach ($errorMessages as $errorMessage) {
                echo "<li>$errorMessage</li>";
            }
                echo "</ul></div>";
            }
        };

        if (!$formComplete) {
            ?>
            <form method="post" action="" class="mt-4" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="text" name="email" id="email" value="<?=$email?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="layout" class="form-label">Layout</label>
                    <select name="layout" id="layout" class="form-select">
                        <option value=""<?php
                        if ($layout === "") {
                            echo " selected";
                        }
                        ?>>-- Please choose --</option>
                        <option value="dark"<?php
                        if ($layout === "dark") {
                            echo " selected";
                        }
                        ?>>Dark</option>
                        <option value="light"<?php
                        if ($layout === "light") {
                            echo " selected";
                        }
                        ?>>Light</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="interests" class="form-label">Interests</label>
                    <select multiple size="3" name="interests[]" id="interests" class="form-select">
                        <option value="1"<?php
                            if (in_array("1", $interestsAsArray)) {
                                echo "selected";
                            }
                        ?>>Concerts</option>
                        <option value="2"<?php
                            if (in_array("2", $interestsAsArray)) {
                                echo "selected";
                            }
                        ?>>Sports</option>
                        <option value="3"<?php
                            if (in_array("3", $interestsAsArray)) {
                                echo "selected";
                            }
                        ?>>Theater</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <label class="form-label me-5">Customer type</label>
                    <div class="mb-3 me-4 form-check">
                    <input type="radio" name="customertype" value="seller" id="seller"<?php
                        if($customertype === "seller") {
                            echo " checked";
                        }
                    ?> class="form-check-input">
                        <label class="form-check-label" for="seller">Seller</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="radio" name="customertype" value="buyer" id="buyer"<?php
                        if($customertype === "buyer") {
                            echo " checked";
                        }
                    ?> class="form-check-input">
                        <label class="form-check-label" for="buyer">Buyer</label>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="tos" value="ok" id="tos"<?php
                        if($tos === "ok") {
                            echo " checked";
                        }
                    ?> class="form-check-input">
                    <label class="form-check-label" for="tos">Accept TOS</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="comments">Comments</label>
                    <textarea name="comments" id="comments" class="form-control"><?=$comments?>
                    </textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="picture">Profile picture</label>
                    <input accept="image/*" type="file" name="picture" id="picture" class="form-control-file">
                    </textarea>
                </div>
                <!-- <input type="submit" name="submit" value="Register" class="btn btn-primary"> -->
                <input type="submit" name="submit" value="Register" class="btn btn-primary">
            </form>
            <?php
        }
        ?>
    </div>
</body>

</html>