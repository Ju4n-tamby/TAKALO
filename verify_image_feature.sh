#!/bin/bash

# Test script for TAKALO image upload feature
# This script verifies that all required files and components are in place

echo "==== TAKALO Image Upload Feature - Verification Script ===="
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if required files exist
echo "Checking required files..."
echo ""

files=(
    "app/controller/ObjetController.php"
    "app/services/ImageService.php"
    "app/repository/ImageRepository.php"
    "app/views/ObjetForm.php"
    "app/views/home.php"
    "app/config/routes.php"
)

all_files_exist=true
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}✓${NC} $file exists"
    else
        echo -e "${RED}✗${NC} $file MISSING"
        all_files_exist=false
    fi
done

echo ""
echo "Checking key methods..."
echo ""

# Check for required methods
grep -q "handleImageUploads" app/controller/ObjetController.php && echo -e "${GREEN}✓${NC} handleImageUploads method found" || echo -e "${RED}✗${NC} handleImageUploads method NOT found"
grep -q "uploadImage" app/services/ImageService.php && echo -e "${GREEN}✓${NC} uploadImage method found" || echo -e "${RED}✗${NC} uploadImage method NOT found"
grep -q "deleteImage" app/controller/ObjetController.php && echo -e "${GREEN}✓${NC} deleteImage method found" || echo -e "${RED}✗${NC} deleteImage method NOT found"
grep -q "image-preview" app/views/ObjetForm.php && echo -e "${GREEN}✓${NC} Image preview UI found" || echo -e "${RED}✗${NC} Image preview UI NOT found"
grep -q "objet-image" app/views/home.php && echo -e "${GREEN}✓${NC} Image display in home view found" || echo -e "${RED}✗${NC} Image display in home view NOT found"

echo ""
echo "Checking routes..."
echo ""

grep -q "delete-image" app/config/routes.php && echo -e "${GREEN}✓${NC} Image delete route found" || echo -e "${RED}✗${NC} Image delete route NOT found"
grep -q "ImageService" app/config/routes.php && echo -e "${GREEN}✓${NC} ImageService integration in routes" || echo -e "${RED}✗${NC} ImageService NOT integrated in routes"

echo ""
echo "Checking database table..."
echo ""

# Try to check if image table exists (requires database connection)
mysql -h localhost -u root -proot takalo -e "DESC image" > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓${NC} Image table exists in database"
else
    echo -e "${YELLOW}⚠${NC} Image table could not be verified (database connection may be needed)"
fi

echo ""
echo "Summary:"
if [ "$all_files_exist" = true ]; then
    echo -e "${GREEN}All required files are in place!${NC}"
else
    echo -e "${RED}Some files are missing. Please review the setup.${NC}"
fi

echo ""
echo "Next steps:"
echo "1. Start the PHP server: php -S localhost:8000 -t public/"
echo "2. Visit http://localhost:8000"
echo "3. Login with admin account"
echo "4. Create or edit an object"
echo "5. Upload images via drag-and-drop or file browser"
echo ""
