<?php
// home.php - Simple, responsive PHP homepage (single-file)
// Instructions: drop into your webroot (e.g., public_html or www) and open in browser.

session_start();

// Simple login simulation for demo (remove in production)
if (isset($_GET['login'])) {
    $_SESSION['user'] = 'Asap Maina';
    header('Location: home.php');
    exit;
}
if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header('Location: home.php');
    exit;
}

// Handle contact form submission (basic)
$contact_success = false;
$contact_errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') $contact_errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $contact_errors[] = 'Valid email is required.';
    if ($message === '') $contact_errors[] = 'Message is required.';

    if (empty($contact_errors)) {
        // In a real app: save to DB or send mail. Here we'll simulate success.
        $contact_success = true;
        // Clear POST to avoid resubmission
        header('Location: home.php?sent=1');
        exit;
    }
}

// Simple helper
function e($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

$user = $_SESSION['user'] ?? null;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Home - My PHP Site</title>
    <style>
        :root{--accent:#2563eb;--muted:#6b7280}
        body{font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; margin:0; color:#111}
        header{background:linear-gradient(90deg,#f8fafc, #fff);box-shadow:0 2px 6px rgba(16,24,40,.05)}
        .container{max-width:1024px;margin:0 auto;padding:1rem}
        nav{display:flex;align-items:center;justify-content:space-between;padding:1rem 0}
        .brand{font-weight:700;color:var(--accent)}
        .nav-links a{margin-left:1rem;text-decoration:none;color:var(--muted)}
        .hero{display:grid;grid-template-columns:1fr;gap:1rem;padding:3rem 1rem}
        .card{background:#fff;border-radius:12px;padding:1.25rem;box-shadow:0 6px 24px rgba(15,23,42,.06)}
        .buttons{margin-top:1rem}
        .btn{display:inline-block;padding:.6rem 1rem;border-radius:8px;text-decoration:none}
        .btn-primary{background:var(--accent);color:#fff}
        .btn-ghost{border:1px solid #e6e9ee;color:var(--accent)}
        .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem}
        footer{padding:2rem 0;color:var(--muted);font-size:.9rem}
        form input, form textarea{width:100%;padding:.6rem;border-radius:8px;border:1px solid #e6e9ee;margin-top:.5rem}
        @media(min-width:768px){.hero{grid-template-columns:1fr 360px;align-items:center}}
    </style>
</head>
<body>
<header>
    <div class="container">
        <nav>
            <div class="brand">MyPHPSite</div>
            <div class="nav-links">
                <a href="#">Home</a>
                <a href="#features">Features</a>
                <a href="#contact">Contact</a>
                <?php if ($user): ?>
                    <a href="?logout=1">Logout (<?php echo e($user); ?>)</a>
                <?php else: ?>
                    <a href="?login=1">Demo Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>

<main class="container">
    <section class="hero">
        <div>
            <div class="card">
                <h1>Welcome<?php echo $user ? ', '.e($user) : ''; ?>!</h1>
                <p style="color:var(--muted)">This is a simple PHP homepage template — responsive, accessible and easy to customize.
                Use it as a starting point for your project.</p>

                <div class="buttons">
                    <a class="btn btn-primary" href="#features">See features</a>
                    <a class="btn btn-ghost" href="#contact">Contact us</a>
                </div>
            </div>

            <h2 id="features" style="margin-top:1.25rem">Features</h2>
            <div class="grid">
                <div class="card">
                    <h3>Responsive layout</h3>
                    <p style="color:var(--muted)">Mobile-first grid that adapts to screen sizes.</p>
                </div>
                <div class="card">
                    <h3>Simple contact form</h3>
                    <p style="color:var(--muted)">Submit the contact form (demo only) with basic validation.</p>
                </div>
                <div class="card">
                    <h3>Session demo</h3>
                    <p style="color:var(--muted)">A tiny login/logout simulation to demonstrate dynamic content.</p>
                </div>
            </div>
        </div>

        <aside>
            <div class="card">
                <h3>Quick info</h3>
                <p style="color:var(--muted)">Server time: <?php echo date('Y-m-d H:i:s'); ?></p>
                <p style="color:var(--muted)">PHP version: <?php echo phpversion(); ?></p>
            </div>

            <div class="card" style="margin-top:1rem">
                <h3>Newsletter</h3>
                <p style="color:var(--muted)">Join our mailing list for updates (demo).</p>
                <form method="post" action="#">
                    <input type="email" name="newsletter_email" placeholder="you@example.com">
                    <div style="margin-top:.6rem"><button class="btn btn-primary">Subscribe</button></div>
                </form>
            </div>
        </aside>
    </section>

    <section id="contact" style="margin-top:1.5rem">
        <div class="card">
            <h2>Contact Us</h2>

            <?php if (!empty($_GET['sent'])): ?>
                <div style="padding:.75rem;border-radius:8px;background:#ecfdf5;color:#065f46;margin-bottom:1rem">Thanks — your message was received (demo).</div>
            <?php endif; ?>

            <?php if (!empty($contact_errors)): ?>
                <div style="padding:.75rem;border-radius:8px;background:#fff1f2;color:#7f1d1d;margin-bottom:1rem">
                    <strong>There were errors:</strong>
                    <ul>
                        <?php foreach($contact_errors as $err): ?>
                            <li><?php echo e($err); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="home.php#contact">
                <label>Name
                    <input type="text" name="name" value="<?php echo e($_POST['name'] ?? ''); ?>" required>
                </label>
                <label style="display:block;margin-top:.6rem">Email
                    <input type="email" name="email" value="<?php echo e($_POST['email'] ?? ''); ?>" required>
                </label>
                <label style="display:block;margin-top:.6rem">Message
                    <textarea name="message" rows="4" required><?php echo e($_POST['message'] ?? ''); ?></textarea>
                </label>
                <div style="margin-top:.75rem">
                    <button class="btn btn-primary" name="contact_submit">Send message</button>
                </div>
            </form>
        </div>
    </section>
</main>



</body>
</html>

