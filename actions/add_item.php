<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item - Elite Finds</title>
    <link rel="stylesheet" href="../css/add_item.css">
</head>
<body>
<div class="main">
    <h1>Add a New Item</h1>
    <form action="submit_item.php" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-row">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-row">
            <label for="department">Department</label>
            <select id="department" name="department" required onchange="updateCategories()">
                <option value="" disabled selected>Select Department</option>
                <?php
                $deptStmt = $pdo->query("SELECT id, d_name FROM Department");
                while ($row = $deptStmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['d_name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-row">
            <label for="category">Category</label>
            <select id="category" name="category" required onchange="updateSubcategories()">
                <option value="" disabled selected>Select Category</option>
            </select>
        </div>
        <div class="form-row">
            <label for="subcategory">Subcategory</label>
            <select id="subcategory" name="subcategory">
                <option value="" selected>No Subcategory</option>
            </select>
        </div>
        <div class="form-row">
            <label for="brand">Brand</label>
            <input type="text" id="brand" name="brand" required>
        </div>
        <div class="form-row">
            <label for="size">Size</label>
            <select id="size" name="size" required>
    <option value="" disabled selected>Select Size</option>
    <?php
    $sizeStmt = $pdo->query("SELECT id, size_description FROM ItemSizes ORDER BY id ASC");
    while ($row = $sizeStmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['size_description']) . "</option>";
    }
    ?>
</select>

        </div>
        <div class="form-row">
            <label for="color">Color</label>
            <input type="text" id="color" name="color" required>
        </div>
        <div class="form-row">
            <label for="condition">Condition</label>
            <select id="condition" name="condition" required>
    <option value="" disabled selected>Select Condition</option>
    <?php
    $stmt = $pdo->query("SELECT id, condition_description FROM ItemConditions ORDER BY id ASC");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['condition_description']) . "</option>";
    }
    ?>
</select>

        </div>
        <div class="form-row">
            <label for="price">Price (€)</label>
            <input type="number" step="0.01" id="price" name="price" required>
        </div>

        <div class="form-row">
            <label for="image1">Image 1 Upload</label>
            <input type="file" id="image1" name="image1" required>
        </div>
        <div class="form-row">
            <label for="image2">Image 2 Upload</label>
            <input type="file" id="image2" name="image2" required>
        </div>
        <div class="form-row">
            <label for="image3">Image 3 Upload</label>
            <input type="file" id="image3" name="image3" required>
        </div>

        <button type="submit">Add Item</button>
    </form>
</div>


<script>
    document.getElementById('department').addEventListener('change', updateCategories);
    document.getElementById('category').addEventListener('change', updateSubcategories);

    function updateCategories() {
        const deptId = document.getElementById('department').value;
        fetch(`../actions/get_categories.php?deptId=${deptId}`)
            .then(response => response.json())
            .then(data => {
                const categorySelect = document.getElementById('category');
                categorySelect.innerHTML = '<option value="" disabled selected>Select Category</option>';
                data.forEach(cat => {
                    categorySelect.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
                });
            });
    }

    function updateSubcategories() {
        const categoryId = document.getElementById('category').value;
        fetch(`../actions/get_subcategories.php?categoryId=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const subcategorySelect = document.getElementById('subcategory');
                subcategorySelect.innerHTML = '<option value="" disabled selected>Select Subcategory</option>';
                data.forEach(sub => {
                    subcategorySelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
            });
    }
</script>
</body>
</html>
