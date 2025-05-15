<?php
include 'connection.php';

$email = $password = $firstName = $lastName = $phone = $address = '';
$errors = array('email' => '', 'password' => '', 'firstName' => '', 'lastName' => '', 'phone' => '', 'address' => '');

function sanitizeInput($data) {
  return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

if (isset($_POST['submit'])) {
  // EMAIL
  if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required!';
  } else {
    $email = sanitizeInput($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Invalid email format!';
    } else {
      // Check for duplicate email
      $emailCheck = mysqli_real_escape_string($conn, $email);
      $checkQuery = "SELECT id FROM users WHERE email = '$emailCheck' LIMIT 1";
      $checkResult = mysqli_query($conn, $checkQuery);
        $errors['email'] = 'Email already exists!';

      if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $errors['email'] = 'Email already exists!';
      }
    }
  }

  // PASSWORD
  if (empty($_POST['password'])) {
    $errors['password'] = 'Password is required!';
  } else {
    $password = sanitizeInput($_POST['password']);
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $password)) {
      $errors['password'] = 'Password must be letters and numbers only!';
    }
  }

  // FIRST NAME
  if (empty($_POST['firstName'])) {
    $errors['firstName'] = 'First name is required!';
  } else {
    $firstName = sanitizeInput($_POST['firstName']);
    if (!preg_match('/^[a-zA-Z\s]+$/', $firstName)) {
      $errors['firstName'] = 'First name must be letters and spaces only!';
    }
  }

  // LAST NAME
  if (empty($_POST['lastName'])) {
    $errors['lastName'] = 'Last name is required!';
  } else {
    $lastName = sanitizeInput($_POST['lastName']);
    if (!preg_match('/^[a-zA-Z\s]+$/', $lastName)) {
      $errors['lastName'] = 'Last name must be letters and spaces only!';
    }
  }

  // PHONE
  if (empty($_POST['phone'])) {
    $errors['phone'] = 'Phone is required!';
  } else {
    $phone = sanitizeInput($_POST['phone']);
    if (!preg_match('/^[0-9]+$/', $phone)) {
      $errors['phone'] = 'Phone must contain numbers only!';
    }
  }

  // ADDRESS
  if (empty($_POST['address'])) {
    $errors['address'] = 'Address is required!';
  } else {
    $address = sanitizeInput($_POST['address']);
    if (!preg_match('/^[a-zA-Z0-9\s,.-]+$/', $address)) {
      $errors['address'] = 'Address must contain valid characters only!';
    }
  }

  // IF NO ERRORS
  if (!array_filter($errors)) {
    //Hash the password before saving
    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID); // or PASSWORD_DEFAULT

    $sql = "INSERT INTO users (email, password, first_name, last_name, phone, address)
            VALUES ('$email', '$hashedPassword', '$firstName', '$lastName', '$phone', '$address')";

    if (mysqli_query($conn, $sql)) {
      echo "<p class='text-green-500'>User registered successfully!</p>";
    } else {
      echo "<p class='text-red-500'>Database error: " . mysqli_error($conn) . "</p>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link
      href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="style.css" />
  </head>
  <body class="min-h-screen flex flex-col">
    <nav class="bg-[#f8f8f8] backdrop-blur shadow-2xl">
      <div class="flex flex-wrap items-center justify-between p-5">
        <a
          href="#"
          class="flex items-center justify-between space-x-3 rtl:space-x-reverse"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="24px"
            viewBox="0 -960 960 960"
            width="24px"
            fill="#00503c"
          >
            <path
              d="m826-585-56-56 30-31-128-128-31 30-57-57 30-31q23-23 57-22.5t57 23.5l129 129q23 23 23 56.5T857-615l-31 30ZM346-104q-23 23-56.5 23T233-104L104-233q-23-23-23-56.5t23-56.5l30-30 57 57-31 30 129 129 30-31 57 57-30 30Zm397-336 57-57-303-303-57 57 303 303ZM463-160l57-58-302-302-58 57 303 303Zm-6-234 110-109-64-64-109 110 63 63Zm63 290q-23 23-57 23t-57-23L104-406q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l63 63 110-110-63-62q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l303 303q23 23 23 56.5T857-441l-57 57q-23 23-57 23t-57-23l-62-63-110 110 63 63q23 23 23 56.5T577-161l-57 57Z"
            />
          </svg>
          <span
            class="self-center text-2xl font-semibold whitespace-nowrap text-[#00503c]"
            >Pinoy Health Buddy</span
          >
        </a>
        <button
          data-collapse-toggle="navbar-default"
          type="button"
          class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
          aria-controls="navbar-default"
          aria-expanded="false"
        >
          <span class="sr-only">Open main menu</span>
          <svg
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 17 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M1 1h15M1 7h15M1 13h15"
            />
          </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
          <ul
            class="font-medium flex flex-col p-4 md:p-0 mt-4 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0"
          >
            <li>
              <a
                href="mainPage.html"
                class="block py-2 px-3 text-[#00503c] bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:text-blue-500"
                aria-current="page"
                >Home</a
              >
            </li>
            <li>
              <a
                href="About.html"
                class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-[#00503c] md:dark:hover:bg-transparent"
                >About</a
              >
            </li>
            <li>
              <a
                href="Services.html"
                class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-[#00503c] md:dark:hover:bg-transparent"
                >Services</a
              >
            </li>
            <li>
              <a
                href="profilePage.html"
                class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-[#00503c] md:dark:hover:bg-transparent"
                >Profile</a
              >
            </li>
            <li>
              <a
                href="Contacts.html"
                class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-[#00503c] md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                >Contact</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <main class="h-[100vh]">
      <!-- --------------------------------LIVE BG START------------------------------->

      <div class="area" id="liveBG">
        <ul class="circles">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
      <!-- --------------------------------LIVE BG END------------------------------->
      <!----------------------------------LOGIN FORMS START------------------------------->

      <!-- <div class="flex justify-center items-center h-full">
        <div class="card" id="loginForm">
          <input
            value=""
            class="blind-check"
            type="checkbox"
            id="blind-input"
            name="blindcheck"
            hidden=""
          />

          <label for="blind-input" class="blind_input">
            <span class="hide">Hide</span>
            <span class="show">Show</span>
          </label>

          <form class="form">
            <div class="title text-center">Log In</div>

            <label class="label_input" for="email-input">Email</label>
            <input
              spellcheck="false"
              class="input"
              type="email"
              name="email"
              id="email-input"
            />

            <div class="frg_pss">
              <label class="label_input" for="password-input">Password</label>
              <a href="">Forgot password?</a>
            </div>
            <input
              spellcheck="false"
              class="input"
              type="text"
              name="password"
              id="password-input"
            />

            <button
              class="submit"
              type="button"
              onclick="window.location.href='profilePage.html';"
            >
              Submit
            </button>
          </form>

          <label for="blind-input" class="avatar">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="35"
              height="35"
              viewBox="0 0 64 64"
              id="monkey"
            >
              <ellipse
                cx="53.7"
                cy="33"
                rx="8.3"
                ry="8.2"
                fill="#89664c"
              ></ellipse>
              <ellipse
                cx="53.7"
                cy="33"
                rx="5.4"
                ry="5.4"
                fill="#ffc5d3"
              ></ellipse>
              <ellipse
                cx="10.2"
                cy="33"
                rx="8.2"
                ry="8.2"
                fill="#89664c"
              ></ellipse>
              <ellipse
                cx="10.2"
                cy="33"
                rx="5.4"
                ry="5.4"
                fill="#ffc5d3"
              ></ellipse>
              <g fill="#89664c">
                <path
                  d="m43.4 10.8c1.1-.6 1.9-.9 1.9-.9-3.2-1.1-6-1.8-8.5-2.1 1.3-1 2.1-1.3 2.1-1.3-20.4-2.9-30.1 9-30.1 19.5h46.4c-.7-7.4-4.8-12.4-11.8-15.2"
                ></path>
                <path
                  d="m55.3 27.6c0-9.7-10.4-17.6-23.3-17.6s-23.3 7.9-23.3 17.6c0 2.3.6 4.4 1.6 6.4-1 2-1.6 4.2-1.6 6.4 0 9.7 10.4 17.6 23.3 17.6s23.3-7.9 23.3-17.6c0-2.3-.6-4.4-1.6-6.4 1-2 1.6-4.2 1.6-6.4"
                ></path>
              </g>
              <path
                d="m52 28.2c0-16.9-20-6.1-20-6.1s-20-10.8-20 6.1c0 4.7 2.9 9 7.5 11.7-1.3 1.7-2.1 3.6-2.1 5.7 0 6.1 6.6 11 14.7 11s14.7-4.9 14.7-11c0-2.1-.8-4-2.1-5.7 4.4-2.7 7.3-7 7.3-11.7"
                fill="#e0ac7e"
              ></path>
              <g fill="#3b302a" class="monkey-eye-nose">
                <path
                  d="m35.1 38.7c0 1.1-.4 2.1-1 2.1-.6 0-1-.9-1-2.1 0-1.1.4-2.1 1-2.1.6.1 1 1 1 2.1"
                ></path>
                <path
                  d="m30.9 38.7c0 1.1-.4 2.1-1 2.1-.6 0-1-.9-1-2.1 0-1.1.4-2.1 1-2.1.5.1 1 1 1 2.1"
                ></path>
                <ellipse
                  cx="40.7"
                  cy="31.7"
                  rx="3.5"
                  ry="4.5"
                  class="monkey-eye-r"
                ></ellipse>
                <ellipse
                  cx="23.3"
                  cy="31.7"
                  rx="3.5"
                  ry="4.5"
                  class="monkey-eye-l"
                ></ellipse>
              </g>
            </svg>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="35"
              height="35"
              viewBox="0 0 64 64"
              id="monkey-hands"
            >
              <path
                fill="#89664C"
                d="M9.4,32.5L2.1,61.9H14c-1.6-7.7,4-21,4-21L9.4,32.5z"
              ></path>
              <path
                fill="#FFD6BB"
                d="M15.8,24.8c0,0,4.9-4.5,9.5-3.9c2.3,0.3-7.1,7.6-7.1,7.6s9.7-8.2,11.7-5.6c1.8,2.3-8.9,9.8-8.9,9.8
	s10-8.1,9.6-4.6c-0.3,3.8-7.9,12.8-12.5,13.8C11.5,43.2,6.3,39,9.8,24.4C11.6,17,13.3,25.2,15.8,24.8"
              ></path>
              <path
                fill="#89664C"
                d="M54.8,32.5l7.3,29.4H50.2c1.6-7.7-4-21-4-21L54.8,32.5z"
              ></path>
              <path
                fill="#FFD6BB"
                d="M48.4,24.8c0,0-4.9-4.5-9.5-3.9c-2.3,0.3,7.1,7.6,7.1,7.6s-9.7-8.2-11.7-5.6c-1.8,2.3,8.9,9.8,8.9,9.8
	s-10-8.1-9.7-4.6c0.4,3.8,8,12.8,12.6,13.8c6.6,1.3,11.8-2.9,8.3-17.5C52.6,17,50.9,25.2,48.4,24.8"
              ></path>
            </svg>
          </label>
        </div> -->
      <div
        class="flex justify-center items-center h-full portrait:h[20vh] overflow-auto"
      >
        <form action="signup.php" method="POST">
          <div
            class="bg-gray-900/40 border-[4px] border-gray-900 rounded-2xl hover:border-green-500 transition-all duration-200"
            id="loginForm"
          >
            <div
              class="mx-auto flex items-center space-y-4 py-16 px-12 font-semibold text-white flex-col portrait:h[20vh] overflow-auto"
            >
              <h1 class="text-white text-2xl">Signup</h1>

                <div class="relative z-0 w-full mb-5 group">
                  <input
                    type="email"
                    name="email"
                    id="email"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "
                    required
                    value="<?php echo sanitizeInput($email) ?>"
                  />
             

                  <label
                    for="email"
                    class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    >Email address</label
                  >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" "
                    required
                    value="<?php echo sanitizeInput($password) ?>"
                  />
                    <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['password']) ?></p>

                  <label
                    for="password"
                    class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    >Password</label
                  >
                </div>
       
                <div class="grid md:grid-cols-2 md:gap-6">
                  <div class="relative z-0 w-full mb-5 group">
                    <input
                      type="text"
                      name="firstName"
                      id="firstName"
                      class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                      placeholder=" "
                      required
                      value="<?php echo sanitizeInput($firstName) ?>" 
                    />
                        <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['firstName']) ?></p>
                    <label
                      for="firstName"
                      class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                      >First name</label
                    >      <p class="text-red-500">
                
                  </div>
                 
                  <div class="relative z-0 w-full mb-5 group">
                    <input
                      type="text"
                      name="lastName"
                      id="lastName"
                      class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                      placeholder=" "
                      required
                      value="<?php echo sanitizeInput($lastName) ?>" 
                    />
                          <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['lastName']) ?>
                  </p>
                    <label
                      for="lastName"
                      class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                      >Last name</label
                    >
                  </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                  <div class="relative z-0 w-full mb-5 group">
                    <input
                      type="number"
                      name="phone"
                      id="phone"
                      class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                      placeholder=""
                      required
                      value="<?php echo sanitizeInput($phone) ?>" 
                    />
                     <p class="text-red-500 text-[15px]"><?php echo sanitizeInput($errors['phone']) ?>
                    <label
                      for="phone"
                      class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                      
                      >Phone
                    </label>
                  </div>
                  <div class="relative z-0 w-full mb-5 group">
                    <input
                      type="text"
                      name="address"
                      id="address"
                      class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                      placeholder=" "
                      required
                      value="<?php echo sanitizeInput($address) ?>" 
                    />
                    <p class="text-red-500 text-[7px]"><?php echo sanitizeInput($errors['address']) ?>
                    <label
                      for="address"
                      class="peer-focus:font-medium absolute text-sm text-white duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                      >Address</label
                    >
                  </div>
                </div>

              <button
                class="w-full p-2 bg-green-500 rounded-full font-bold text-white border-[4px] border-gray-700 hover:border-blue-500 transition-all duration-200"
                name="submit"
                type="submit"
              >
                Submit
              </button>
              <p class="font-semibold text-white transition-all duration-200">
                Do you have an account?
                <a
                  class="font-semibold text-blue-400 hover:text-blue-500 transition-all duration-200"
                  href="index.html"
                  >Log in</a
                >
              </p>
            </div>
          </div>
        </form>
      </div>
      <!-- --------------------------------LOGIN FORMS END------------------------------->
    </main>

    <footer class="text-[#00503c] py-8 w-[99vw]">
      <div class="w-[99vw]">
        <div class="flex flex-wrap justify-between items-center w-[99vw]">
          <a
            href="#"
            class="flex items-center space-x-3 rtl:space-x-reverse mb-4 sm:mb-0"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              height="32px"
              viewBox="0 -960 960 960"
              width="32px"
              fill="white"
            >
              <path
                d="m826-585-56-56 30-31-128-128-31 30-57-57 30-31q23-23 57-22.5t57 23.5l129 129q23 23 23 56.5T857-615l-31 30ZM346-104q-23 23-56.5 23T233-104L104-233q-23-23-23-56.5t23-56.5l30-30 57 57-31 30 129 129 30-31 57 57-30 30Zm397-336 57-57-303-303-57 57 303 303ZM463-160l57-58-302-302-58 57 303 303Zm-6-234 110-109-64-64-109 110 63 63Zm63 290q-23 23-57 23t-57-23L104-406q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l63 63 110-110-63-62q-23-23-23-57t23-57l57-57q23-23 56.5-23t56.5 23l303 303q23 23 23 56.5T857-441l-57 57q-23 23-57 23t-57-23l-62-63-110 110 63 63q23 23 23 56.5T577-161l-57 57Z"
              />
            </svg>
            <span class="self-center text-2xl font-bold whitespace-nowrap"
              >Pinoy Health Buddy</span
            >
          </a>
          <div
            class="flex flex-wrap items-center justify-center text-sm font-medium"
          >
            <a href="About.html" class="hover:underline m-3">About</a>
            <a href="#" class="hover:underline m-3">Privacy Policy</a>
            <a href="#" class="hover:underline m-3">Licensing</a>
            <a href="Contacts.html" class="hover:underline m-3">Contact</a>
          </div>
        </div>
        <hr class="my-6 border-gray-200 opacity-50" />
        <div class="text-center w-[99vw]">
          <p class="text-sm">
            © 2025
            <a href="#" class="hover:underline font-bold">Pinoy Health Buddy™</a
            >. All Rights Reserved.
          </p>
          <p class="text-sm mt-2">
            Designed with by
            <a
              href="https://github.com/Jay-Scripts"
              class="hover:underline font-bold"
              >JayScripts</a
            >
          </p>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  </body>
</html>
