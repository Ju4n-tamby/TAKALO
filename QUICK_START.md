# 🚀 Quick Start Guide - TAKALO Image Upload Feature

## Prerequisites

- PHP 8.0+
- MySQL/MariaDB
- Composer (already installed)
- Modern web browser
- Basic terminal knowledge

## Installation & Setup

### 1. Database Setup
```bash
# Ensure database exists and schema is loaded
mysql -u root -p takalo < database.sql
```

### 2. Directory Permissions
```bash
# Make public directory writable for image uploads
chmod 755 public/
chmod 755 public/uploads  # Will be auto-created
```

### 3. Install Dependencies (if not done)
```bash
composer install
composer dump-autoload
```

### 4. Start Development Server
```bash
# From project root
php -S localhost:8000 -t public/
```

### 5. Access the Application
```
URL: http://localhost:8000
```

## User Flow - First Time Setup

### Step 1: Login
1. Navigate to http://localhost:8000
2. Login with admin account (see database.sql for credentials)
   - Username: `admin`
   - Password: `admin` (hashed in database)

### Step 2: Create First Object with Images
1. Click "Créer un objet" button
2. Fill in the form:
   - **Nom**: (e.g., "Vintage Bicycle")
   - **Description**: (e.g., "Red mountain bike, good condition")
   - **Catégorie**: (select from dropdown)
   - **Prix**: (e.g., "150.00")
3. Upload images:
   - Click the dashed box or drag and drop images
   - Max 5 images per object
   - Supported: JPEG, PNG, GIF, WebP
   - Max size: 5MB per image
4. See live preview with remove buttons
5. Click "➕ Ajouter" to create object

### Step 3: View Objects on Dashboard
1. After creation, redirected to home page
2. See object cards with:
   - First uploaded image as thumbnail
   - Object name and category
   - Price in green
   - Edit and Delete buttons

### Step 4: Edit Object and Manage Images
1. Click "✏️ Modifier" on any object card
2. Form loads with pre-filled data
3. See existing images in "Images existantes" section
4. Delete existing images by clicking ✕
5. Add new images using same upload interface
6. Click "✏️ Modifier" to save changes

## API Endpoints

### Image Operations
```
GET    /objets/create              → Show create form
POST   /objets/create              → Create object with images
GET    /objets/edit/:id            → Show edit form
POST   /objets/edit/:id            → Update object with images
GET    /objets/delete/:id          → Delete object (and all images)
GET    /objets/delete-image/:id    → Delete single image
```

## File Locations

### Source Files
```
/app/controller/ObjetController.php     ← Image handling logic
/app/services/ImageService.php          ← File upload logic
/app/repository/ImageRepository.php     ← Database operations
/app/views/ObjetForm.php                ← Upload UI
/app/views/home.php                     ← Image display
/app/config/routes.php                  ← Route definitions
```

### Upload Directory
```
/public/uploads/                        ← Auto-created
  ├── 67abc123_photo.jpg
  ├── 67abc234_image.png
  └── ...
```

## Image Upload Process

1. **Client-Side**
   - User selects/drags images
   - JavaScript validates type and size
   - Preview generated with FileReader API
   - Max 5 images enforced

2. **Server-Side**
   - Form submitted with POST
   - controller/ObjetController.php receives request
   - handleImageUploads() processes files
   - ImageService::uploadImage() validates and stores
   - ImageRepository::addImage() saves metadata
   - User redirected to home

3. **File Storage**
   - Unique filename: `uniqid()_originalname.ext`
   - Stored in `/public/uploads/`
   - URL saved in database: `/uploads/filename.ext`
   - Accessible via browser at `/uploads/...`

## Validation Rules

### File Type
- ✅ JPEG (.jpg, .jpeg)
- ✅ PNG (.png)
- ✅ GIF (.gif)
- ✅ WebP (.webp)
- ❌ Everything else (rejected)

### File Size
- ✅ Up to 5MB per image
- ❌ Larger files rejected

### Quantity
- ✅ 1-5 images per object
- ❌ 6+ images rejected

### Security
- User ownership verified before operations
- Filenames sanitized and unique
- Stored outside web root (relative path)
- Proper MIME type validation

## Troubleshooting

### Images not uploading?
1. Check browser console for errors
2. Verify `/public` directory is writable
3. Check PHP error logs
4. Ensure image files are valid formats

### Can't see uploaded images?
1. Verify database image records exist
2. Check if `/public/uploads/` directory exists
3. Verify file permissions on uploaded files
4. Check image path in database

### "Too many files" error?
- Maximum 5 images per object
- Remove some images and try again
- Or edit object to delete existing ones first

### "File too large" error?
- Maximum 5MB per image
- Compress image before uploading
- Use online image compressor if needed

### Permission denied errors?
```bash
# Fix directory permissions
chmod -R 755 public/
chmod -R 755 public/uploads
```

## Development Notes

### Extending the Feature

**Add image compression:**
```php
// In ImageService::uploadImage()
$image = imagecreatefromjpeg($tmp_name);
imagejpeg($image, $filepath, 85); // 85% quality
```

**Add image reordering:**
- Add order field to image table
- Create drag-drop reorder UI
- Update database on reorder

**Add image gallery:**
- Create detailed view for object
- Show all images in carousel/gallery
- Allow users to switch between images

## Browser Support

| Browser | Support | Notes |
|---------|---------|-------|
| Chrome  | ✅ Full | Best experience |
| Firefox | ✅ Full | Full support |
| Safari  | ✅ Full | Full support |
| Edge    | ✅ Full | Full support |
| IE 11   | ⚠️ Limited | No drag-drop, file input works |

## Performance Tips

1. **Optimize images before upload**
   - Resize large images
   - Use appropriate formats
   - Compress when possible

2. **Database optimization**
   - Index id_objet in image table
   - Implement pagination for large lists

3. **Filesystem optimization**
   - Organize uploads by date/user
   - Implement cleanup for orphaned files

## Next Steps

### Recommended Enhancements
1. Image compression on server
2. Thumbnail generation
3. Image carousel on object detail page
4. Batch operations (multi-delete)
5. Image search/filter
6. CDN integration for images

### Advanced Features
1. AI-powered image recognition
2. Image metadata extraction
3. Duplicate image detection
4. Smart cropping suggestions
5. Image attribution/licensing

## Support & Help

For issues or questions:
1. Check IMPLEMENTATION_SUMMARY.md
2. Review IMAGE_UPLOAD_FEATURE.md
3. Check PHP error logs
4. Verify database structure
5. Test with simple images first

## Environment Variables (if needed)

```env
# Max upload size (in bytes)
MAX_UPLOAD_SIZE=5242880  # 5MB

# Allowed extensions
ALLOWED_EXTENSIONS=jpg,jpeg,png,gif,webp

# Upload directory
UPLOAD_DIR=/public/uploads
```

---

**Happy uploading! 🎉**

For detailed technical information, see IMPLEMENTATION_SUMMARY.md

