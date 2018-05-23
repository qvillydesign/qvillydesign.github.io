<?php

$login = new \Inc\Utils\Login();

if ($login->isUserLoggedIn() == true) {
    header("Location: $baseController->website_url/page.php?name=user");
    die();

} else {
    require_once($baseController->website_path . "/template/_header.php");
    $userName = isset($_POST['userName']) ? $_POST['userName'] : "";
    $userEmail = isset($_POST['userEmail']) ? $_POST['userEmail'] : "";

    ?>
    <main>
        <section class="flex-container-center fit-height-section">
            <div class="container flex-item-center">
                <form class="form-signin" method="post" action="page.php?name=registration" name="registerform">
                    <h2 class="form-signin-heading">Регистрация</h2>

                    <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->

                    <label for="register_input_username" class="sr-only">Имя пользователя</label>
                    <input name="userName" id="register_input_username" class="form-control" placeholder="Имя пользователя"
                           required="" type="text" pattern="[a-zA-Z0-9]{2,64}" autofocus="" autocomplete="off"
                           value="<?php echo $userName; ?>">
                    <label for="register_input_email" class="sr-only">Email</label>
                    <input name="userEmail" id="register_input_email" class="form-control" placeholder="Email"
                           required="" type="email" autocomplete="off" value="<?php echo $userEmail; ?>">

                    <label for="register_input_password" class="sr-only">Пароль</label>
                    <input name="userPasswordNew" id="register_input_password" class="form-control"
                           placeholder="Пароль" type="password" autocomplete="off" required="" autocomplete="nope">

                    <label for="login_input_password_repeat" class="sr-only">Подтверждение пароля</label>
                    <input name="userPassword_repeat" id="login_input_password_repeat" class="form-control"
                           placeholder="Подтверждение пароля" type="password" autocomplete="off" required="" autocomplete="nope">

                    <br>
                    <button class="btn btn-lg btn-primary btn-block" name="register" type="submit">Регистрация</button>
                </form>
                <a href="page.php?name=login">Вернуться на страницу входа</a>

            </div>
        </section>
    </main>

    <?php
    require_once($baseController->website_path . "/template/_footer.php");

}