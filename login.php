<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Sign Up : Golden Crust </title>
    <link rel="stylesheet" href="css/login.css" />
  </head>
  <body>
    <video autoplay muted loop id="background-video">
    <source src="pic/CroissantVid.mp4" type="video/mp4">
   
  </video>
    <section class="wrapper">
      <div class="form signup">
        <header>Signup</header>
        <form action="php/process-signin.php" method="post">
          <input type="text" placeholder="Full name" name="name" required />
          <input type="text" placeholder="Email address"  name="email" required />
          <input type="password" placeholder="Password" name="password" required />
          <input type="submit" value="Signup" />
        </form>
      </div>

      <div class="form login">
        <header>Login</header>
        <form action="php/process-login.php" method="post">
          <input type="text" placeholder="Email address" name="email" required />
          <input type="password" placeholder="Password" name="password" required />
          <a href="#">Forgot password?</a>
          <input type="submit" value="Login" />
        </form>
      </div>

      <script>
        const wrapper = document.querySelector(".wrapper"),
          signupHeader = document.querySelector(".signup header"),
          loginHeader = document.querySelector(".login header");
              
                      // Check if the URL contains '?login=true'
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('login') && urlParams.get('login') === 'true') {
                // If 'login=true' is present in the URL, make the login form active
                wrapper.classList.add("active");
            }

        loginHeader.addEventListener("click", () => {
          wrapper.classList.add("active");
        });
        signupHeader.addEventListener("click", () => {
          wrapper.classList.remove("active");
        });
        
      </script>
      <script src="javascript/cart.js" defer></script>
    </section>
  </body>
</html>
