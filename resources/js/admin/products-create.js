document.addEventListener("DOMContentLoaded", function () {
    // Khai báo các biến DOM
    const productType = document.getElementById("product_type");
    const simpleProduct = document.getElementById("simple-product");
    const variableProduct = document.getElementById("variable-product");
    const nameInput = document.getElementById("name");
    const simpleSkuInput = document.getElementById("simple_sku");
    const variableSkuInput = document.getElementById("variable_sku");
    const simpleSlugInput = document.getElementById("simple_slug");
    const variableSlugInput = document.getElementById("variable_slug");
    const attributesContainer = document.getElementById("attributes-container");
    const addAttributeBtn = document.getElementById("add-attribute");
    const generateVariationsBtn = document.getElementById(
        "generate-variations"
    );
    const variationsContainer = document.getElementById("variations-container");
    const variationsTableBody = document.getElementById(
        "variations-table-body"
    );
    const variationsTableContainer = document.getElementById(
        "variations-table-container"
    );
    const setVariationsQuantityBtn = document.getElementById(
        "set-variations-quantity"
    );
    const featuredImageInput = document.querySelector(
        'input[name="featured_image"]'
    );
    const galleryImagesInput = document.querySelector(
        'input[name="gallery_images[]"]'
    );
    const videoPathInput = document.querySelector('input[name="video_path"]');

    // Check if in edit mode
    const isEditMode = !!document.querySelector(
        'input[name="_method"][value="PUT"]'
    );

    // Khai báo danh sách thuộc tính
    const colors = window.colors || [];
    const sizes = window.sizes || [];
    let spherical_values = window.spherical_values || [];
    let cylindrical_values = window.cylindrical_values || [];

    // Chuẩn hóa dữ liệu từ chuỗi thành đối tượng { id, name }
    if (typeof spherical_values[0] === "string") {
        spherical_values = spherical_values.map((name, idx) => ({
            id: window.spherical_ids ? window.spherical_ids[idx] : name,
            name,
        }));
    }
    if (typeof cylindrical_values[0] === "string") {
        cylindrical_values = cylindrical_values.map((name, idx) => ({
            id: window.cylindrical_ids ? window.cylindrical_ids[idx] : name,
            name,
        }));
    }

    // Lưu trữ tạm thời thông tin file
    let tempFiles = {
        featured_image: null,
        gallery_images: [],
        variation_images: [],
        video_path: null,
    };

    // Load thông tin file từ localStorage (nếu có)
    function loadTempFiles() {
        const storedFiles = localStorage.getItem("temp_product_files");
        if (storedFiles) {
            tempFiles = JSON.parse(storedFiles);
            updateFilePreviews();
        }
    }

    // Cập nhật bản xem trước hoặc tên file
    function updateFilePreviews() {
        // Ảnh đại diện
        if (tempFiles.featured_image) {
            const preview = document.createElement("small");
            preview.className = "text-muted";
            featuredImageInput.insertAdjacentElement("afterend", preview);
        }

        // Album ảnh
        if (tempFiles.gallery_images.length > 0) {
            const previewDiv = document.createElement("div");
            previewDiv.className = "mt-2";

            galleryImagesInput.insertAdjacentElement("afterend", previewDiv);
        }

        // Video
        if (tempFiles.video_path) {
            const preview = document.createElement("small");
            preview.className = "text-muted";
            preview.textContent = `Đã chọn: ${tempFiles.video_path.name}`;
            videoPathInput.insertAdjacentElement("afterend", preview);
        }

        // Ảnh biến thể
        document
            .querySelectorAll(".variation-image-input")
            .forEach((input, index) => {
                if (tempFiles.variation_images[index]) {
                    const preview = document.createElement("small");
                    preview.className = "text-muted";

                    input.insertAdjacentElement("afterend", preview);
                }
            });
    }

    // Lưu file vào tempFiles và localStorage
    function saveTempFile(input, type, index = null) {
        if (type === "featured_image" && input.files[0]) {
            tempFiles.featured_image = { name: input.files[0].name };
        } else if (type === "gallery_images" && input.files.length > 0) {
            tempFiles.gallery_images = Array.from(input.files).map((file) => ({
                name: file.name,
            }));
        } else if (type === "video_path" && input.files[0]) {
            tempFiles.video_path = { name: input.files[0].name };
        } else if (type === "variation_image" && input.files[0]) {
            tempFiles.variation_images[index] = { name: input.files[0].name };
        }
        localStorage.setItem("temp_product_files", JSON.stringify(tempFiles));
        updateFilePreviews();
    }

    // Xử lý sự kiện chọn file
    if (featuredImageInput) {
        featuredImageInput.addEventListener("change", () =>
            saveTempFile(featuredImageInput, "featured_image")
        );
    }
    if (galleryImagesInput) {
        galleryImagesInput.addEventListener("change", () =>
            saveTempFile(galleryImagesInput, "gallery_images")
        );
    }
    if (videoPathInput) {
        videoPathInput.addEventListener("change", () =>
            saveTempFile(videoPathInput, "video_path")
        );
    }

    // Hàm tạo SKU ngẫu nhiên và Slug thân thiện SEO
    function generateSkuAndSlug(name, prefix = "") {
        const randomId = Math.random().toString(36).substring(2, 10);
        const sanitizedName =
            name
                .toLowerCase()
                .replace(/[^a-z0-9\s]/g, "")
                .replace(/\s+/g, "-")
                .substring(0, 50) || "product";
        const sku = `${prefix}${sanitizedName}-${randomId}`;
        const slug = `${prefix}${sanitizedName}`;
        return { sku, slug };
    }

    // Cập nhật SKU và Slug khi nhập tên sản phẩm
    if (
        nameInput &&
        simpleSkuInput &&
        simpleSlugInput &&
        variableSkuInput &&
        variableSlugInput
    ) {
        nameInput.addEventListener("input", function () {
            if (!isEditMode) {
                const { sku, slug } = generateSkuAndSlug(this.value);
                simpleSkuInput.value = sku;
                simpleSlugInput.value = slug;
                variableSkuInput.value = `VAR-${sku}`;
                variableSlugInput.value = `var-${slug}`;
            }
        });
    }

    // Xử lý chuyển đổi loại sản phẩm
    if (productType) {
        function toggleProductType() {
            if (productType.value === "simple") {
                simpleProduct.style.display = "block";
                variableProduct.style.display = "none";
            } else {
                simpleProduct.style.display = "none";
                variableProduct.style.display = "block";
                if (!isEditMode) {
                    const { sku, slug } = generateSkuAndSlug(
                        nameInput.value || "product",
                        "VAR-"
                    );
                    variableSkuInput.value = sku;
                    variableSlugInput.value = `var-${slug}`;
                }
            }
        }
        productType.addEventListener("change", toggleProductType);
        toggleProductType();
    }

    // Xử lý định dạng giá trị số
    document.querySelectorAll(".price-input").forEach((input) => {
        input.addEventListener("input", function (e) {
            let value = e.target.value.replace(/[^0-9]/g, "");
            e.target.value = value;
        });
        input.addEventListener("blur", function (e) {
            if (e.target.value === "") {
                e.target.value = "0";
            }
            updateVariationsTable();
        });
    });

    // Xử lý thêm thuộc tính
    if (addAttributeBtn && attributesContainer) {
        addAttributeBtn.addEventListener("click", function () {
            const attributeRows =
                attributesContainer.getElementsByClassName("attribute-row");
            if (attributeRows.length >= 4) {
                addAttributeBtn.style.display = "none";
                return;
            }

            const existingTypes = Array.from(attributeRows).map(
                (row) => row.querySelector(".attribute-type")?.value || ""
            );
            const index = attributeRows.length;
            const availableTypes = [
                "color",
                "size",
                "spherical",
                "cylindrical",
            ].filter((t) => !existingTypes.includes(t));
            if (availableTypes.length === 0) return;

            const row = document.createElement("div");
            row.className = "attribute-row row g-2 mb-2";
            row.setAttribute("data-index", index);
            row.innerHTML = `
                <div class="col-md-3">
                    <select name="attributes[${index}][type]" class="form-select attribute-type" data-index="${index}">
                        ${availableTypes
                            .map(
                                (t) =>
                                    `<option value="${t}">${
                                        t === "color"
                                            ? "Màu sắc"
                                            : t === "size"
                                            ? "Kích thước"
                                            : t === "spherical"
                                            ? "Độ cận"
                                            : "Độ loạn"
                                    }</option>`
                            )
                            .join("")}
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="attribute-values-tags"></div>
                    <div class="border rounded p-3 attribute-values-container" style="max-height: 200px; overflow-y: auto;"></div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-attribute">Xóa</button>
                </div>
            `;
            attributesContainer.appendChild(row);

            const typeSelect = row.querySelector(".attribute-type");
            const tagsContainer = row.querySelector(".attribute-values-tags");
            const valuesContainer = row.querySelector(
                ".attribute-values-container"
            );

            function updateValuesContainer(selectedType, rowIndex) {
                valuesContainer.innerHTML = "";
                const options =
                    selectedType === "color"
                        ? colors
                        : selectedType === "size"
                        ? sizes
                        : selectedType === "spherical"
                        ? spherical_values
                        : cylindrical_values;

                if (options.length === 0) {
                    valuesContainer.innerHTML =
                        '<p class="text-muted">Không có giá trị nào để chọn.</p>';
                    return;
                }

                options.forEach((option) => {
                    const value =
                        option.id !== undefined && option.id !== null
                            ? String(option.id)
                            : String(option.name || option);
                    const label = option.name || option;
                    const div = document.createElement("div");
                    div.className = "form-check";
                    div.innerHTML = `
                        <input type="checkbox" class="form-check-input attribute-value-checkbox"
                            name="attributes[${rowIndex}][values][]"
                            value="${value}"
                            data-index="${rowIndex}">
                        <label class="form-check-label">${label}</label>
                    `;
                    valuesContainer.appendChild(div);
                });
            }

            typeSelect.addEventListener("change", function () {
                const rowIndex =
                    this.closest(".attribute-row").getAttribute("data-index");
                updateValuesContainer(this.value, rowIndex);
                checkGenerateButton();
            });

            valuesContainer.addEventListener("change", function (e) {
                if (e.target.classList.contains("attribute-value-checkbox")) {
                    const rowIndex = e.target.getAttribute("data-index");
                    const selectedValues = Array.from(
                        valuesContainer.querySelectorAll(
                            `input[name="attributes[${rowIndex}][values][]"]:checked`
                        )
                    ).map((cb) => cb.value);
                    tagsContainer.innerHTML = "";
                    selectedValues.forEach((value) => {
                        let label = value;
                        if (typeSelect.value === "color")
                            label =
                                colors.find((c) => c.id == value)?.name ||
                                value;
                        else if (typeSelect.value === "size")
                            label =
                                sizes.find((s) => s.id == value)?.name || value;
                        else if (typeSelect.value === "spherical")
                            label =
                                spherical_values.find((s) => s.id == value)
                                    ?.name || value;
                        else if (typeSelect.value === "cylindrical")
                            label =
                                cylindrical_values.find((c) => c.id == value)
                                    ?.name || value;

                        const tag = document.createElement("span");
                        tag.className = "tag";
                        tag.innerHTML = `${label}<input type="hidden" name="attributes[${rowIndex}][values][]" value="${value}"><button type="button" class="remove-tag" data-value="${value}">×</button>`;
                        tagsContainer.appendChild(tag);
                    });
                    checkGenerateButton();
                    updateAddAttributeBtn();
                }
            });

            tagsContainer.addEventListener("click", function (e) {
                if (e.target.classList.contains("remove-tag")) {
                    const value = e.target.getAttribute("data-value");
                    const checkbox = valuesContainer.querySelector(
                        `input[value="${value}"]`
                    );
                    if (checkbox) checkbox.checked = false;
                    e.target.parentElement.remove();
                    checkGenerateButton();
                    updateAddAttributeBtn();
                }
            });

            row.querySelector(".remove-attribute").addEventListener(
                "click",
                function () {
                    row.remove();
                    checkGenerateButton();
                    updateAddAttributeBtn();
                    updateAttributeTypeOptions();
                }
            );

            updateValuesContainer(typeSelect.value, index);
            updateAddAttributeBtn();
        });
    }

    // Cập nhật danh sách tùy chọn trong select box loại thuộc tính
    function updateAttributeTypeOptions() {
        const attributeRows =
            attributesContainer.getElementsByClassName("attribute-row");
        const usedTypes = Array.from(attributeRows).map(
            (r) => r.querySelector(".attribute-type")?.value || ""
        );
        const allTypes = ["color", "size", "spherical", "cylindrical"];

        Array.from(attributeRows).forEach((r, rowIndex) => {
            const typeSelect = r.querySelector(".attribute-type");
            const currentType = typeSelect.value;
            const availableTypes = allTypes.filter(
                (t) => !usedTypes.includes(t) || t === currentType
            );
            typeSelect.innerHTML = availableTypes
                .map(
                    (t) =>
                        `<option value="${t}" ${
                            t === currentType ? "selected" : ""
                        }>${
                            t === "color"
                                ? "Màu sắc"
                                : t === "size"
                                ? "Kích thước"
                                : t === "spherical"
                                ? "Độ cận"
                                : "Độ loạn"
                        }</option>`
                )
                .join("");
            r.setAttribute("data-index", rowIndex);
            updateValuesContainer(typeSelect.value, rowIndex);
        });
    }

    // Hiển thị/ẩn nút "Thêm thuộc tính"
    function updateAddAttributeBtn() {
        if (!attributesContainer) return;
        const attributeRows =
            attributesContainer.getElementsByClassName("attribute-row");
        const types = Array.from(attributeRows).map(
            (row) => row.querySelector(".attribute-type")?.value || ""
        );
        if (
            attributeRows.length >= 4 ||
            (types.includes("color") &&
                types.includes("size") &&
                types.includes("spherical") &&
                types.includes("cylindrical"))
        ) {
            addAttributeBtn.style.display = "none";
        } else {
            addAttributeBtn.style.display = "block";
        }
    }

    // Cập nhật bảng hiển thị biến thể
    function updateVariationsTable() {
        if (!variationsTableBody || !variationsContainer) return;
        variationsTableBody.innerHTML = "";
        const variationRows =
            variationsContainer.getElementsByClassName("variation-row");

        Array.from(variationRows).forEach((row, index) => {
            const nameInput = row.querySelector('input[name$="[name]"]');
            const skuInput = row.querySelector('input[name$="[sku]"]');
            const priceInput = row.querySelector('input[name$="[price]"]');
            const salePriceInput = row.querySelector(
                'input[name$="[sale_price]"]'
            );
            const quantityInput = row.querySelector(
                'input[name$="[quantity]"]'
            );
            const imageInput = row.querySelector('input[name$="[image]"]');

            const name = nameInput?.value || "";
            const sku = skuInput?.value || "";
            const price = priceInput?.value
                ? parseFloat(priceInput.value).toLocaleString("vi-VN")
                : "0";
            const salePrice = salePriceInput?.value
                ? parseFloat(salePriceInput.value).toLocaleString("vi-VN")
                : "0";
            const quantity = quantityInput?.value || "0";

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${name}</td>
                <td>${sku}</td>
                <td>${price} VNĐ</td>
                <td>${salePrice} VNĐ</td>
                <td>${quantity}</td>
                <td class="variation-image-cell"></td>
            `;
            variationsTableBody.appendChild(tr);

            const imageCell = tr.querySelector(".variation-image-cell");
            if (imageInput.files && imageInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.alt = "Ảnh biến thể";
                    img.className = "variation-image";
                    img.style.maxWidth = "50px";
                    img.style.maxHeight = "50px";
                    imageCell.innerHTML = ""; // Xóa nội dung cũ
                    imageCell.appendChild(img);
                };
                reader.readAsDataURL(imageInput.files[0]);
            } else {
                // Nếu không có file mới, dùng tên từ <small> sau input (từ session khi lỗi)
                const previewSmall = imageInput.nextElementSibling;
                if (
                    previewSmall &&
                    previewSmall.classList.contains("text-muted")
                ) {
                    imageCell.textContent = previewSmall.textContent;
                } else {
                    imageCell.textContent = "Không có ảnh";
                }
            }
        });

        variationsTableContainer.style.display =
            variationRows.length > 0 ? "block" : "none";
    }

    // Xử lý nút "Đặt số lượng cho tất cả biến thể"
    if (setVariationsQuantityBtn) {
        setVariationsQuantityBtn.addEventListener("click", function () {
            const variationRows =
                variationsContainer.getElementsByClassName("variation-row");
            if (variationRows.length === 0) {
                alert("Chưa có biến thể nào để thêm số lượng.");
                return;
            }

            let quantity;
            while (true) {
                quantity = prompt(
                    "Nhập số lượng cho tất cả biến thể (VD: 100):"
                );
                if (quantity === null) return;
                quantity = quantity.trim();
                const parsedQuantity = parseInt(quantity);
                if (isNaN(parsedQuantity) || parsedQuantity < 0) {
                    alert(
                        "Vui lòng nhập số lượng hợp lệ (số nguyên không âm)."
                    );
                    continue;
                }
                break;
            }

            Array.from(variationRows).forEach((row) => {
                const quantityInput = row.querySelector(
                    'input[name$="[quantity]"]'
                );
                if (quantityInput) {
                    quantityInput.value = quantity;
                    quantityInput.classList.remove("is-invalid");
                }
            });
            updateVariationsTable();
        });
    }

    // Cập nhật hiển thị nút tạo biến thể và bảng
    function checkGenerateButton() {
        if (!attributesContainer || !generateVariationsBtn) return;
        const attributeRows =
            attributesContainer.getElementsByClassName("attribute-row");
        let hasValues = false;
        for (let row of attributeRows) {
            const tags = row.querySelectorAll(".tag");
            if (tags.length > 0) {
                hasValues = true;
                break;
            }
        }
        generateVariationsBtn.style.display = hasValues ? "block" : "none";
        variationsContainer.style.display =
            variationsContainer.children.length > 0 ? "block" : "none";
        variationsTableContainer.style.display =
            variationsContainer.children.length > 0 ? "block" : "none";
        if (!isEditMode) {
            setVariationsQuantityBtn.style.display =
                variationsContainer.children.length > 0 ? "block" : "none";
        }
    }

    // Tạo tất cả tổ hợp giá trị thuộc tính
    function generateCombinations(attributes) {
        if (attributes.length === 0) return [[]];
        const first = attributes[0];
        const rest = attributes.slice(1);
        const combinationsOfRest = generateCombinations(rest);
        const result = [];
        for (let val of first.values) {
            for (let combo of combinationsOfRest) {
                result.push([
                    { type: first.type, value: val.trim() },
                    ...combo,
                ]);
            }
        }
        return result;
    }

    // Cập nhật biến thể và bảng
    function updateVariations(
        attributesContainer,
        variationsContainer,
        variableSkuInput
    ) {
        const attributeRows = Array.from(
            attributesContainer.getElementsByClassName("attribute-row")
        );
        const attributes = attributeRows
            .map((row) => {
                const typeSelect = row.querySelector(".attribute-type");
                if (!typeSelect) return null;
                const type = typeSelect.value;
                const values = Array.from(
                    row.querySelectorAll(".attribute-value-checkbox:checked")
                ).map((cb) => cb.value.trim());
                return values.length ? { type, values } : null;
            })
            .filter((attr) => attr);

        if (!attributes.length) {
            alert("Vui lòng chọn ít nhất một giá trị cho một thuộc tính!");
            return;
        }

        const rawCombinations = generateCombinations(attributes);

        const existingVariationRows = Array.from(
            variationsContainer.getElementsByClassName("variation-row")
        );

        const validCombinations = rawCombinations.map((combo) => {
            let color_id = "",
                size_id = "",
                spherical_id = "",
                cylindrical_id = "";
            let colorName = "",
                sizeName = "",
                sphericalName = "",
                cylindricalName = "";

            combo.forEach((item) => {
                if (item.type === "color") {
                    color_id = item.value;
                    const color = colors.find(
                        (c) => String(c.id) === String(color_id)
                    );
                    colorName = color ? color.name : item.value;
                }
                if (item.type === "size") {
                    size_id = item.value;
                    const size = sizes.find(
                        (s) => String(s.id) === String(size_id)
                    );
                    sizeName = size ? size.name : item.value;
                }
                if (item.type === "spherical") {
                    spherical_id = item.value;
                    const spherical = spherical_values.find(
                        (s) => String(s.id) === String(spherical_id)
                    );
                    sphericalName = spherical ? spherical.name : item.value;
                }
                if (item.type === "cylindrical") {
                    cylindrical_id = item.value;
                    const cylindrical = cylindrical_values.find(
                        (c) => String(c.id) === String(cylindrical_id)
                    );
                    cylindricalName = cylindrical
                        ? cylindrical.name
                        : item.value;
                }
            });

            const nameParts = [
                colorName,
                sizeName,
                sphericalName,
                cylindricalName,
            ].filter(Boolean);
            const name = nameParts.join(" - ");

            return { name, color_id, size_id, spherical_id, cylindrical_id };
        });

        const existingVariations = existingVariationRows.map((row) => {
            const nameInput = row.querySelector('input[name$="[name]"]');
            const colorInput = row.querySelector('input[name$="[color_id]"]');
            const sizeInput = row.querySelector('input[name$="[size_id]"]');
            const sphericalInput = row.querySelector(
                'input[name$="[spherical_id]"]'
            );
            const cylindricalInput = row.querySelector(
                'input[name$="[cylindrical_id]"]'
            );

            return {
                name: nameInput?.value.trim(),
                color_id: colorInput?.value,
                size_id: sizeInput?.value,
                spherical_id: sphericalInput?.value,
                cylindrical_id: cylindricalInput?.value,
            };
        });

        existingVariationRows.forEach((row, index) => {
            const existingVariation = existingVariations[index];
            const isValid = validCombinations.some((combo) => {
                if (combo.name === existingVariation.name) return true;
                if (
                    combo.color_id === existingVariation.color_id &&
                    combo.size_id === existingVariation.size_id &&
                    combo.spherical_id === existingVariation.spherical_id &&
                    combo.cylindrical_id === existingVariation.cylindrical_id
                ) {
                    return true;
                }
                return false;
            });

            if (!isValid) {
                row.remove();
            }
        });

        const remainingVariations = Array.from(
            variationsContainer.getElementsByClassName("variation-row")
        ).map((row) => {
            const nameInput = row.querySelector('input[name$="[name]"]');
            return nameInput?.value.trim();
        });

        const newCombinations = validCombinations.filter(
            (combo) => !remainingVariations.includes(combo.name)
        );

        newCombinations.forEach((combo, idx) => {
            const globalIndex =
                variationsContainer.getElementsByClassName(
                    "variation-row"
                ).length;
            const skuPrefix = variableSkuInput?.value.trim() || "VAR";
            const randomId = Math.random().toString(36).substring(2, 10);
            const variationSku = `${skuPrefix}-${combo.name
                .toLowerCase()
                .replace(/\s+/g, "-")}-${randomId}`;

            const row = document.createElement("div");
            row.className = "variation-row row g-2 mb-2";

            const hiddenInputs = [];
            if (combo.color_id)
                hiddenInputs.push(
                    `<input type="hidden" name="variations[${globalIndex}][color_id]" value="${combo.color_id}">`
                );
            if (combo.size_id)
                hiddenInputs.push(
                    `<input type="hidden" name="variations[${globalIndex}][size_id]" value="${combo.size_id}">`
                );
            if (combo.spherical_id)
                hiddenInputs.push(
                    `<input type="hidden" name="variations[${globalIndex}][spherical_id]" value="${combo.spherical_id}">`
                );
            if (combo.cylindrical_id)
                hiddenInputs.push(
                    `<input type="hidden" name="variations[${globalIndex}][cylindrical_id]" value="${combo.cylindrical_id}">`
                );

            row.innerHTML = `
                <div class="col-md-2">
                    <input type="text" name="variations[${globalIndex}][name]" value="${
                combo.name
            }" class="form-control" placeholder="Tên biến thể" readonly>
                    ${hiddenInputs.join("")}
                </div>
                <div class="col-md-2">
                    <input type="text" name="variations[${globalIndex}][sku]" value="${variationSku}" class="form-control" placeholder="Mã sản phẩm">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control price-input" name="variations[${globalIndex}][price]" value="" placeholder="Nhập giá (VD: 1000)">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control price-input" name="variations[${globalIndex}][sale_price]" value="" placeholder="Nhập giá (VD: 900)">
                </div>
                <div class="col-md-1">
                    <input type="number" class="form-control" name="variations[${globalIndex}][quantity]" value="0" min="0" placeholder="Nhập số lượng">
                </div>
                <div class="col-md-2">
                    <input type="file" name="variations[${globalIndex}][image]" class="form-control variation-image-input">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-variation">Xóa</button>
                </div>
            `;
            variationsContainer.appendChild(row);

            // Thêm sự kiện để cập nhật bảng khi thay đổi
            row.querySelectorAll(
                'input[name$="[quantity]"], input[name$="[price]"], input[name$="[sale_price]"], input[name$="[sku]"], input[name$="[image]"]'
            ).forEach((input, inputIndex) => {
                if (input.type === "file") {
                    input.addEventListener("change", () => {
                        saveTempFile(input, "variation_image", globalIndex);
                        updateVariationsTable();
                    });
                } else {
                    input.addEventListener("change", updateVariationsTable);
                }
            });
        });

        variationsContainer.style.display =
            variationsContainer.children.length > 0 ? "block" : "none";
        variationsTableContainer.style.display =
            variationsContainer.children.length > 0 ? "block" : "none";
        if (!isEditMode) {
            setVariationsQuantityBtn.style.display =
                variationsContainer.children.length > 0 ? "block" : "none";
        }
        updateVariationsTable();
    }

    if (generateVariationsBtn && attributesContainer && variationsContainer) {
        generateVariationsBtn.addEventListener("click", function () {
            updateVariations(
                attributesContainer,
                variationsContainer,
                variableSkuInput
            );
            if (!isEditMode) {
                setTimeout(() => {
                    promptAllVariationPrices();
                }, 200);
            }
        });

        function promptAllVariationPrices() {
            const variationRows =
                variationsContainer.getElementsByClassName("variation-row");
            if (!variationRows.length) return;
            let basePrice = null;
            let salePrice = null;
            while (true) {
                basePrice = prompt(
                    "Nhập giá gốc cho tất cả biến thể (VD: 1000 hoặc 1234.56):",
                    basePrice || ""
                );
                if (basePrice === null) return;
                basePrice = basePrice.replace(",", ".").trim();
                if (
                    !basePrice ||
                    isNaN(parseFloat(basePrice)) ||
                    parseFloat(basePrice) < 0
                ) {
                    alert("Vui lòng nhập giá gốc hợp lệ (số dương).");
                    continue;
                }
                break;
            }
            while (true) {
                salePrice = prompt(
                    "Nhập giá khuyến mãi cho tất cả biến thể (có thể bỏ trống):",
                    salePrice || ""
                );
                if (salePrice === null) return;
                if (salePrice === "") {
                    salePrice = "";
                    break;
                }
                salePrice = salePrice.replace(",", ".").trim();
                if (
                    !salePrice ||
                    isNaN(parseFloat(salePrice)) ||
                    parseFloat(salePrice) < 0
                ) {
                    alert(
                        "Vui lòng nhập giá khuyến mãi hợp lệ (số dương hoặc để trống)."
                    );
                    continue;
                }
                if (parseFloat(salePrice) > parseFloat(basePrice)) {
                    alert("Giá khuyến mãi không được lớn hơn giá gốc!");
                    continue;
                }
                break;
            }
            Array.from(variationRows).forEach((row) => {
                const priceInput = row.querySelector('input[name$="[price]"]');
                const salePriceInput = row.querySelector(
                    'input[name$="[sale_price]"]'
                );
                if (priceInput) priceInput.value = basePrice;
                if (salePriceInput) salePriceInput.value = salePrice;
            });
            updateVariationsTable();
        }
    }

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-variation")) {
            const variationRows =
                variationsContainer.getElementsByClassName("variation-row");
            if (variationRows.length <= 1) {
                alert(
                    "Bạn không thể xóa biến thể này vì sản phẩm phải có ít nhất một biến thể."
                );
                return;
            }
            if (confirm("Bạn có chắc muốn xóa biến thể này?")) {
                const rowIndex = Array.from(variationRows).indexOf(
                    e.target.closest(".variation-row")
                );
                e.target.closest(".variation-row").remove();
                tempFiles.variation_images.splice(rowIndex, 1); // Xóa ảnh biến thể tương ứng
                localStorage.setItem(
                    "temp_product_files",
                    JSON.stringify(tempFiles)
                );
                variationsContainer.style.display =
                    variationsContainer.children.length > 0 ? "block" : "none";
                variationsTableContainer.style.display =
                    variationsContainer.children.length > 0 ? "block" : "none";
                if (!isEditMode) {
                    setVariationsQuantityBtn.style.display =
                        variationsContainer.children.length > 0
                            ? "block"
                            : "none";
                }
                updateVariationsTable();
            }
        }
    });

    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function (e) {
            const attributeRows =
                attributesContainer?.getElementsByClassName("attribute-row") ||
                [];
            Array.from(attributeRows).forEach((row, idx) => {
                const checkedValues = row.querySelectorAll(
                    ".attribute-value-checkbox:checked"
                );
                if (checkedValues.length === 0) {
                    row.querySelectorAll(
                        '[name^="attributes[' + idx + ']"]'
                    ).forEach((input) => {
                        input.disabled = true;
                    });
                }
            });
            const priceInput = form.querySelector('input[name="price"]');
            const salePriceInput = form.querySelector(
                'input[name="sale_price"]'
            );
            const quantityInput = form.querySelector('input[name="quantity"]');
            const variationPriceInputs = form.querySelectorAll(
                'input[name^="variations"][name$="[price]"]'
            );
            const variationSalePriceInputs = form.querySelectorAll(
                'input[name^="variations"][name$="[sale_price]"]'
            );
            const variationQuantityInputs = form.querySelectorAll(
                'input[name^="variations"][name$="[quantity]"]'
            );

            let hasError = false;

            if (productType?.value === "simple") {
                if (priceInput && priceInput.value) {
                    let priceValue = priceInput.value.replace(",", ".");
                    if (
                        isNaN(parseFloat(priceValue)) ||
                        parseFloat(priceValue) < 0
                    ) {
                        priceInput.classList.add("is-invalid");
                        hasError = true;
                    } else {
                        priceInput.classList.remove("is-invalid");
                        priceInput.value = parseFloat(priceValue).toString();
                    }
                }
                if (quantityInput && quantityInput.value) {
                    let quantityValue = parseInt(quantityInput.value);
                    if (isNaN(quantityValue) || quantityValue < 0) {
                        quantityInput.classList.add("is-invalid");
                        hasError = true;
                    } else {
                        quantityInput.classList.remove("is-invalid");
                        quantityInput.value = quantityValue;
                    }
                }
            }

            [...variationPriceInputs, ...variationSalePriceInputs].forEach(
                (input) => {
                    if (input && input.value) {
                        let priceValue = input.value.replace(",", ".");
                        if (
                            isNaN(parseFloat(priceValue)) ||
                            parseFloat(priceValue) < 0
                        ) {
                            input.classList.add("is-invalid");
                            hasError = true;
                        } else {
                            input.classList.remove("is-invalid");
                            input.value = parseFloat(priceValue).toString();
                        }
                    }
                }
            );

            variationQuantityInputs.forEach((input) => {
                if (input && input.value) {
                    let quantityValue = parseInt(input.value);
                    if (isNaN(quantityValue) || quantityValue < 0) {
                        input.classList.add("is-invalid");
                        hasError = true;
                    } else {
                        input.classList.remove("is-invalid");
                        input.value = quantityValue;
                    }
                }
            });

            if (hasError) {
                alert("Vui lòng nhập giá và số lượng hợp lệ (số dương).");
                e.preventDefault();
            } else {
                // Lưu thông tin file vào localStorage trước khi submit
                localStorage.setItem(
                    "temp_product_files",
                    JSON.stringify(tempFiles)
                );
            }
            // Log variations gửi lên
            const variations = [];
            const variationRows =
                variationsContainer?.getElementsByClassName("variation-row") ||
                [];
            Array.from(variationRows).forEach((row, idx) => {
                const name = row.querySelector('input[name$="[name]"]')?.value;
                const color_id = row.querySelector(
                    'input[name$="[color_id]"]'
                )?.value;
                const size_id = row.querySelector(
                    'input[name$="[size_id]"]'
                )?.value;
                const spherical_id = row.querySelector(
                    'input[name$="[spherical_id]"]'
                )?.value;
                const cylindrical_id = row.querySelector(
                    'input[name$="[cylindrical_id]"]'
                )?.value;
                variations.push({
                    name,
                    color_id,
                    size_id,
                    spherical_id,
                    cylindrical_id,
                });
            });
        });
    });

    // Thêm listener cho tất cả input ảnh biến thể (cập nhật table ngay khi change)
    document.querySelectorAll(".variation-image-input").forEach((input) => {
        input.addEventListener("change", () => {
            saveTempFile(
                input,
                "variation_image",
                Array.from(
                    document.querySelectorAll(".variation-image-input")
                ).indexOf(input)
            );
            updateVariationsTable();
        });
    });

    // Khởi tạo
    loadTempFiles();
    updateAddAttributeBtn();
    checkGenerateButton();
    updateVariationsTable();
});
