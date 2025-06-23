<?php
require_once 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$page_title = "Recommended Meals";
include 'includes/header.php';
?>

<div class="container">
    <h1 class="page-title">Recommended Meals for Diabetes Management</h1>
    <p class="page-description">Here you will find a selection of healthy and balanced meal ideas suitable for individuals managing diabetes. Always consult with your doctor or a registered dietitian before making significant changes to your diet.</p>

    <div class="meal-section">
        <h2 class="section-title">Breakfast Ideas</h2>
        <div class="meal-card-container">
            <div class="meal-card">
                <img src="images/oatmeal.jpg" alt="Oatmeal with Berries">
                <h3>Oatmeal with Berries and Nuts</h3>
                <p>A fiber-rich breakfast that helps regulate blood sugar. Use rolled oats, add fresh berries for antioxidants, and a sprinkle of nuts for healthy fats.</p>
            </div>
            <div class="meal-card">
                <img src="images/scrambled_eggs.jpg" alt="Scrambled Eggs with Vegetables">
                <h3>Scrambled Eggs with Spinach and Tomatoes</h3>
                <p>A protein-packed option that keeps you full. Combine eggs with non-starchy vegetables like spinach, mushrooms, and tomatoes.</p>
            </div>
        </div>
    </div>

    <div class="meal-section">
        <h2 class="section-title">Lunch Ideas</h2>
        <div class="meal-card-container">
            <div class="meal-card">
                <img src="images/grilled_chicken_salad.jpg" alt="Grilled Chicken Salad">
                <h3>Grilled Chicken Salad</h3>
                <p>Lean protein with a variety of fresh vegetables. Use a light vinaigrette dressing and avoid sugary additions.</p>
            </div>
            <div class="meal-card">
                <img src="images/lentil_soup.jpg" alt="Lentil Soup">
                <h3>Hearty Lentil Soup</h3>
                <p>Lentils are a great source of fiber and protein. Prepare with plenty of vegetables and low-sodium broth.</p>
            </div>
        </div>
    </div>

    <div class="meal-section">
        <h2 class="section-title">Dinner Ideas</h2>
        <div class="meal-card-container">
            <div class="meal-card">
                <img src="images/baked_salmon.jpg" alt="Baked Salmon with Asparagus">
                <h3>Baked Salmon with Roasted Asparagus</h3>
                <p>Rich in Omega-3 fatty acids, salmon is excellent for heart health. Pair with non-starchy vegetables like asparagus or broccoli.</p>
            </div>
            <div class="meal-card">
                <img src="images/turkey_stir_fry.jpg" alt="Turkey Stir-fry">
                <h3>Turkey and Vegetable Stir-fry</h3>
                <p>A quick and customizable meal. Use lean ground turkey or sliced turkey breast with a colorful mix of vegetables and a low-sodium soy sauce.</p>
            </div>
        </div>
    </div>

    <div class="meal-section">
        <h2 class="section-title">Snack Ideas</h2>
        <div class="meal-card-container">
            <div class="meal-card">
                <img src="images/greek_yogurt.jpg" alt="Greek Yogurt with Berries">
                <h3>Greek Yogurt with a Handful of Berries</h3>
                <p>High in protein and calcium, Greek yogurt is a satisfying snack. Add a small portion of berries for natural sweetness and fiber.</p>
            </div>
            <div class="meal-card">
                <img src="images/almonds.jpg" alt="Almonds">
                <h3>A Small Handful of Almonds</h3>
                <p>Almonds provide healthy fats and fiber, helping to stabilize blood sugar levels. Control portion sizes to manage calorie intake.</p>
            </div>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>

