<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JNEC Requisition Management System | JNEC Bhutan</title>
    <style>
        /* Basic inline styles - move to style.css for better practice */
        body { font-family: sans-serif; line-height: 1.6; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 20px auto; padding: 0 20px; }

        /* --- Header Styling --- */
        header {
            display: flex; /* Enable Flexbox */
            justify-content: space-between; /* Push logos to edges, center title */
            align-items: center; /* Vertically align items in the middle */
            padding: 10px 20px; /* Add some padding */
            border-bottom: 1px solid #ccc;
            /* margin-bottom: 30px; */ /* Removed margin-bottom from header, let container handle top margin */
            background-color: #fff; /* Optional: Give header a background */
        }

        header .logo {
            max-height: 60px; /* Adjust max height for your logos */
            width: auto; /* Maintain aspect ratio */
        }

        header .title-container {
            text-align: center; /* Center the text within this div */
            margin: 0 15px; /* Add some space between title and logos */
        }

        header h1 {
            color: #333;
            margin: 0 0 5px 0; /* Adjust margin */
            font-size: 1.8em; /* Adjust font size if needed */
        }

        header p.college-name { /* Added class for clarity */
            margin: 0;
            color: #555;
        }
        /* --- End Header Styling --- */

        h2 { color: #555; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 30px;}
        p { margin-bottom: 15px; }
        footer { text-align: center; margin-top: 40px; padding: 20px; background-color: #f4f4f4; border-top: 1px solid #ccc; font-size: 0.9em; color: #555;}
        a { color: #0066cc; text-decoration: none; }
        a:hover { text-decoration: underline; }
        /* Updated placeholder style slightly */
        .placeholder-input { color: rgb(10, 10, 10); font-style: italic; background-color: #fff0f0; padding: 2px; }
        /* Style for the text you provided */
        .provided-text { font-style: italic; }
        .mission-vision p { font-style: italic; }
    </style>
</head>
<body>

    <header>  <!-- Header starts here -->
        <!-- Left Logo - REPLACE src and alt -->
        <!-- Suggestion: Be more specific if rub.png is RUB logo -->
        <img src="{{ asset('images/rub.png') }}" alt="Royal University of Bhutan Logo" class="logo">

        <!-- Title Container -->
        <div class="title-container">
            <h1>JNEC Requisition Management System</h1>
            <p class="college-name">Jigme Namgyel Engineering College, Bhutan</p>
        </div>

        <!-- Right Logo - REPLACE src and alt -->
        <img src="{{ asset('images/jnec.png') }}" alt="Jigme Namgyel Engineering College Logo" class="logo">
    </header> <!-- Header ends here -->

    <!-- Container starts AFTER the header -->
    <div class="container">

        <section id="description">
            <h2>About the System</h2>
            <p>
                <!-- Text you provided -->
                <span class="provided-text">The JNEC Requisition Management System is an online platform designed to simplify and track the process for requesting resources and services within the college.</span>
            </p>
            <p>
                 Log in here: <a href="[Link to JNEC Bhutan Requisition System Login Page]" target="_blank"><span class="placeholder-input">[Link to Login Page]</span></a>
                 <!-- Example: <a href="{{ route('login') }}">Log In</a> -->
            </p>
        </section>

        <section id="mission" class="mission-vision">
            <h2>Our Mission</h2>
            <p>
                <!-- Text you provided -->
                <span class="provided-text">To streamline the requisition process, enhance efficiency, and ensure timely procurement of necessary resources for JNEC operations.</span>
            </p>
        </section>

        <section id="vision" class="mission-vision">
            <h2>Our Vision</h2>
            <p>
                <!-- Text you provided -->
                <span class="provided-text">To be a fully integrated, transparent, and user-friendly digital solution that supports effective resource management and accountability at JNEC.</span>
            </p>
        </section>

        <section id="support">
             <h2>Need Help?</h2>
             <p>
                 For assistance, please contact <span class="placeholder-input">[Relevant Contact Person/Department]</span> at <a href="mailto:[Support Email Address]"><span class="placeholder-input">[Support Email Address]</span></a> or call <a href="tel:[Support Phone Number]"><span class="placeholder-input">[Support Phone Number]</span></a>.
                 <!-- Example: Contact ICT Services at <a href="mailto:ict@jnec.edu.bt">ict@jnec.edu.bt</a> -->
             </p>
        </section>

    </div> <!-- Container ends here -->

    <footer>
        <!-- Updated placeholder for year -->
        <!-- Consider using PHP to get the current year dynamically -->
        <p>© <span class="placeholder-input">{{ date('Y') }}</span> Jigme Namgyel Engineering College (JNEC), Bhutan.</p>
    </footer>

</body>
</html>