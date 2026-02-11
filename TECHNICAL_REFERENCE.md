# TAKALO Image Upload - Technical Reference

## 🔧 Developer Quick Reference

### Database Schema

```sql
-- Image table (referenced in routes.php and repositories)
CREATE TABLE image (
    id_image INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    id_objet INT NOT NULL,
    FOREIGN KEY (id_objet) REFERENCES objet(id_objet) ON DELETE CASCADE
);

-- Relationship: One object has many images (1:N)
-- Cascade delete: Deleting object deletes all images
```

### Key Constants

```php
// File Upload Limits
define('MAX_IMAGES_PER_OBJECT', 5);
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('UPLOAD_DIR', __DIR__ . '/../public/uploads');

// Allowed MIME Types
define('ALLOWED_MIMES', [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp'
]);
```

### API Endpoints

```
GET    /                              Login page
POST   /log                           User authentication
GET    /home                          Dashboard with objects/images

GET    /objets/create                Show create form
POST   /objets/create                Create object + upload images
GET    /objets/edit/{id}             Show edit form with images
POST   /objets/edit/{id}             Update object + images
GET    /objets/delete/{id}           Delete object + cascade
GET    /objets/delete-image/{id}     Delete single image
```

### Repository Layer

```php
// ImageRepository.php Methods
class ImageRepository {
    public function addImage($id_objet, $url)
        // INSERT into image table
        // Returns: bool (success)
        
    public function getImagesByObjet($id_objet)
        // SELECT * from image WHERE id_objet
        // Returns: array of images
        
    public function deleteImage($id_image)
        // DELETE from image WHERE id_image
        // Returns: bool (success)
        
    public function getImageById($id_image)
        // SELECT * from image WHERE id_image
        // Returns: single image array
}
```

### Service Layer

```php
// ImageService.php Methods
class ImageService {
    public function uploadImage($file)
        // Validate file (MIME type, size)
        // Create /public/uploads directory
        // Generate unique filename
        // Move file to storage
        // Returns: '/uploads/filename' or false
        
    public function addImage($id_objet, $url)
        // Wrapper to ImageRepository::addImage()
        // Returns: bool
        
    public function getImagesByObjet($id_objet)
        // Wrapper to ImageRepository::getImagesByObjet()
        // Returns: array of images
        
    public function deleteImage($id_image)
        // Wrapper to ImageRepository::deleteImage()
        // Returns: bool
        
    public function getImageById($id_image)
        // Wrapper to ImageRepository::getImageById()
        // Returns: single image
}
```

### Controller Layer

```php
// ObjetController.php Methods
class ObjetController {
    public function createObjet()
        // 1. Create object via ObjetService
        // 2. Get returned object ID
        // 3. Call handleImageUploads($id, $_FILES)
        // 4. Redirect to /home
        
    public function updateObjet($id)
        // 1. Verify object ownership
        // 2. Update object via ObjetService
        // 3. Call handleImageUploads($id, $_FILES) if files provided
        // 4. Redirect to /home
        
    public function deleteObjet($id)
        // 1. Verify ownership
        // 2. Delete all images (both DB and filesystem)
        // 3. Delete object
        // 4. Redirect
        
    public function deleteImage($id)
        // 1. Get image and verify ownership
        // 2. Delete file from filesystem
        // 3. Delete from database
        // 4. Redirect to edit form
        
    private function handleImageUploads($id_objet, $files)
        // 1. Loop through $_FILES['images']
        // 2. For each file (max 5):
        //    - Call ImageService::uploadImage($file)
        //    - If success, call ImageService::addImage($id, $path)
        // 3. Enforces max 5 images per object
        
    private function deleteImageFile($url)
        // 1. Construct full file path
        // 2. If exists, unlink()
        // 3. Handle errors gracefully
}
```

### File Upload Flow Diagram

```
User Form (/objets/create or /objets/edit/:id)
    ↓
enctype="multipart/form-data"
    ↓
$_FILES['images'] array
    ↓
ObjetController::createObjet() or updateObjet()
    ↓
Create/Update object in database
    ↓
handleImageUploads($id_objet, $_FILES)
    ├─ Loop: $_FILES['images']['tmp_name'] as $index
    ├─ Create $file array from components
    └─ For each file (max 5):
        ├─ ImageService::uploadImage($file)
        │  ├─ Validate MIME type
        │  ├─ Validate file size
        │  ├─ mkdir /public/uploads (if needed)
        │  ├─ Generate filename: uniqid() . '_' . basename
        │  ├─ move_uploaded_file() to /public/uploads/
        │  └─ Return '/uploads/filename'
        │
        └─ ImageService::addImage($id_objet, $path)
           └─ ImageRepository::addImage()
              └─ INSERT into image (url, id_objet)
    ↓
Redirect to /home
    ↓
UserController::showHome()
    ├─ ObjetService::getObjetsByUserId($user_id)
    ├─ Load images for each object:
    │  └─ ImageService::getImagesByObjet($id_objet)
    └─ Render home.php with $objets[$i]['images']
        └─ Display thumbnails
```

### Data Structures

```php
// $_FILES Structure
$_FILES['images'] = [
    'name' => ['photo1.jpg', 'photo2.png', ...],
    'type' => ['image/jpeg', 'image/png', ...],
    'tmp_name' => ['/tmp/phpabc123', '/tmp/phpxyz789', ...],
    'error' => [0, 0, ...],
    'size' => [2048000, 3072000, ...]
];

// Image Record Structure
$image = [
    'id_image' => 1,
    'url' => '/uploads/67abc123_photo.jpg',
    'id_objet' => 5
];

// Object with Images Structure
$objet = [
    'id_objet' => 5,
    'nom' => 'Bicycle',
    'description' => 'Red mountain bike',
    'prix' => '150.00',
    'id_category' => 2,
    'id_user' => 1,
    'images' => [
        ['id_image' => 1, 'url' => '/uploads/...', 'id_objet' => 5],
        ['id_image' => 2, 'url' => '/uploads/...', 'id_objet' => 5],
        // ... up to 5 images
    ]
];
```

### Error Handling

```php
// Upload Errors
if ($file['error'] !== UPLOAD_ERR_OK)
    // Log error, skip file, continue

// Size Validation
if ($file['size'] > 5 * 1024 * 1024)
    // Skip file, log warning, continue

// Type Validation
if (!in_array($file['type'], $allowed))
    // Skip file, log warning, continue

// Move Failed
if (!move_uploaded_file($tmp, $path))
    // Log error, skip file, continue

// Database Error
if (!$repo->addImage($id, $url))
    // Log error, but file is stored
    // (inconsistent state - should cleanup)
```

### Security Checks

```php
// User Ownership Verification
$objet = $this->objetService->getObjetById($id);
if ($objet['id_user'] != $_SESSION['user']['id_user']) {
    Flight::redirect('/home');
    return;
}

// Session Verification
if (!isset($_SESSION['user'])) {
    Flight::redirect('/');
    return;
}

// Admin Check (if needed)
if ($_SESSION['user']['id_type_user'] != 1) {
    // Admin-only operation
    Flight::redirect('/home');
    return;
}

// CSRF Protection (added manually if needed)
// if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token'])
```

### Database Queries

```sql
-- Insert Image
INSERT INTO image (url, id_objet) VALUES (:url, :id_objet);

-- Get Images for Object
SELECT * FROM image WHERE id_objet = :id_objet;

-- Get Single Image
SELECT * FROM image WHERE id_image = :id_image;

-- Delete Image
DELETE FROM image WHERE id_image = :id_image;

-- Delete All Images for Object
DELETE FROM image WHERE id_objet = :id_objet;

-- Cascade Delete (automatic via FK)
DELETE FROM objet WHERE id_objet = :id;
-- All related images automatically deleted
```

### Environment Configuration

```php
// In routes.php or config.php
$uploadDir = __DIR__ . '/../public/uploads';
$maxUploadSize = 5 * 1024 * 1024; // 5MB
$maxImagesPerObject = 5;
$allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Database connection
$pdo = Flight::db();
// PDO with prepared statements prevents SQL injection

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Testing Strategies

```php
// Unit Test: ImageService::uploadImage()
// - Test valid JPEG file
// - Test valid PNG file
// - Test oversized file (> 5MB)
// - Test non-image file
// - Verify unique filename generation
// - Verify directory creation

// Integration Test: ObjetController::createObjet()
// - Create object with 1 image
// - Create object with 5 images
// - Try to create with 6 images (should limit to 5)
// - Verify database records created
// - Verify files stored in /public/uploads

// UI Test: ObjetForm.php
// - Drag files to drop zone
// - Click to browse files
// - See preview of selected images
// - Remove image from preview
// - Submit form
// - Verify redirect to home

// End-to-End Test
// - Login
// - Create object with images
// - View on dashboard
// - Edit object, add more images
// - Delete individual image
// - Delete object (cascade)
// - Verify files deleted
```

### Debugging Tips

```php
// Check uploaded files
var_dump($_FILES);

// Check image records
SELECT * FROM image WHERE id_objet = ?;

// Check file storage
ls -la public/uploads/

// Check permissions
stat public/uploads/
stat public/uploads/filename.jpg

// Check database table
DESCRIBE image;
SHOW CREATE TABLE image;

// Check PHP configuration
phpinfo(); // Check upload_max_filesize, post_max_size

// Check error logs
tail -f /var/log/php-errors.log
```

### Performance Optimization

```php
// Lazy Load Images (already implemented)
// Only load images when needed:
if ($this->imageService) {
    $objet['images'] = $this->imageService->getImagesByObjet($objet['id_objet']);
}

// Batch Load (for multiple objects)
$images = $db->query("SELECT * FROM image WHERE id_objet IN (?, ?, ?)", $ids);
$imagesByObjet = [];
foreach ($images as $img) {
    $imagesByObjet[$img['id_objet']][] = $img;
}

// Pagination (for large image lists)
SELECT * FROM image WHERE id_objet = ? LIMIT 10 OFFSET ?;

// Caching (optional)
$cache->set("images_$objetId", $images, 3600); // 1 hour
```

### Extending the Feature

```php
// Add Image Compression
public function uploadImage($file) {
    // ... existing validation ...
    
    $image = imagecreatefromjpeg($uploadPath);
    imagejpeg($image, $uploadPath, 85); // 85% quality
    imagedestroy($image);
    
    return $relativePath;
}

// Add Thumbnail Generation
public function generateThumbnail($imagePath, $width = 200, $height = 200) {
    $thumb = imagecreatetruecolor($width, $height);
    // ... resize logic ...
    imagejpeg($thumb, $thumbPath, 90);
    imagedestroy($thumb);
    return $thumbPath;
}

// Add Image Reordering
public function reorderImages($imageIds) {
    // imageIds = [3, 1, 2]
    // Update order in database
    foreach ($imageIds as $index => $id) {
        UPDATE image SET order = ? WHERE id_image = ?
    }
}

// Add Image Search
public function searchByImageSimilarity($imagePath) {
    // Use image hashing or ML model
    // Find similar images
}
```

### Troubleshooting Reference

| Issue | Cause | Solution |
|-------|-------|----------|
| Images not uploaded | No /uploads dir | `mkdir public/uploads` |
| Files not stored | No write permission | `chmod 755 public` |
| MIME type error | Wrong validation | Check file MIME types |
| Size error | File too large | Compress before upload |
| Database error | Table missing | Create image table |
| Images not displayed | Path incorrect | Check URL format |
| 404 on images | File deleted | Regenerate from DB |

---

## 📚 Related Files

- `/app/controller/ObjetController.php` - Main logic
- `/app/services/ImageService.php` - File handling
- `/app/repository/ImageRepository.php` - Database ops
- `/app/views/ObjetForm.php` - Upload UI
- `/app/views/home.php` - Display UI
- `/app/config/routes.php` - Routing

---

## 🔗 Documentation Links

- Technical Details: IMAGE_UPLOAD_FEATURE.md
- Implementation Guide: IMPLEMENTATION_SUMMARY.md
- User Guide: QUICK_START.md
- Change Log: CHANGELOG.md

---

**Last Updated**: February 11, 2026
**Version**: 1.0.0
**Status**: Production Ready

