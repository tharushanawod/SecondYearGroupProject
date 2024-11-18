<?php
class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle file upload
            $image = '';
            if (isset($_FILES['image'])) {
                $image = $this->uploadImage($_FILES['image']);
            }

            $productData = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'category' => $_POST['category'],
                'image' => $image,
                'stock' => $_POST['stock']
            ];

            if ($this->productModel->addProduct($productData)) {
                header('Location: /admin/products?success=1');
                exit;
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'category' => $_POST['category'],
                'stock' => $_POST['stock']
            ];

            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $productData['image'] = $this->uploadImage($_FILES['image']);
            } else {
                $productData['image'] = $_POST['existing_image'];
            }

            if ($this->productModel->updateProduct($productData)) {
                header('Location: /admin/products?updated=1');
                exit;
            }
        }
    }

    public function delete() {
        if (isset($_POST['id'])) {
            if ($this->productModel->deleteProduct($_POST['id'])) {
                echo json_encode(['success' => true]);
                exit;
            }
        }
        echo json_encode(['success' => false]);
    }

    private function uploadImage($file) {
        $target_dir = "public/images/products/";
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $newFileName = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $newFileName;

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $newFileName;
        }
        return '';
    }
}
?>