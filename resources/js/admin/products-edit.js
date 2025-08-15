document.addEventListener("DOMContentLoaded", function () {
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
    const setVariationsPriceBtn = document.getElementById(
        "set-variations-price"
    );

    // Danh sách màu sắc, kích thước, độ cận và độ loạn từ PHP
    const colors = window.colors || [];
    const sizes = window.sizes || [];
    const spherical_values = window.spherical_values || [];
    const cylindrical_values = window.cylindrical_values || [];

    // Check if edit mode
    const isEditMode = !!document.querySelector(
        'input[name="_method"][value="PUT"]'
    );

    // Gỡ lỗi trường quantity
    const simpleQuantity = document.querySelector('input[name="quantity"]');
    if (simpleQuantity) {
        console.log("Quantity input:", simpleQuantity);
        console.log(
            "Display:",
            window.getComputedStyle(simpleQuantity).display
        );
        console.log(
            "Visibility:",
            window.getComputedStyle(simpleQuantity).visibility
        );
        console.log(
            "Opacity:",
            window.getComputedStyle(simpleQuantity).opacity
        );
        console.log("ReadOnly:", simpleQuantity.readOnly);
    }

    // Tự động sinh SKU và Slug
    function generateSkuAndSlug(name, prefix = "") {
        const timestamp = Date.now();
        const sanitizedName =
            name
                .toLowerCase()
                .replace(/[^a-z0-9\s]/g, "")
                .replace(/\s+/g, "-") || "product";
        const sku = `${prefix}${sanitizedName}-${timestamp}`;
        const slug = `${prefix}${sanitizedName}-${timestamp}`;
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
            let value = e.target.value.replace(/[^0-9,.]/g, "");
            if (value.includes(",")) value = value.replace(",", ".");
            if (value.split(".").length > 2) value = value.replace(/\.+$/, "");
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
                    const value = option.id || option;
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
                        const tag = document.createElement("span");
                        tag.className = "tag";
                        tag.innerHTML = `${value}<input type="hidden" name="attributes[${rowIndex}][values][]" value="${value}"><button type="button" class="remove-tag" data-value="${value}">×</button>`;
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
    }

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
            const name =
                nameParts.join(" - ") ||
                `Biến thể ${existingVariationRows.length + 1}`;

            return { name, color_id, size_id, spherical_id, cylindrical_id };
        });

        const existingVariations = existingVariationRows.map((row) => {
            const nameInput = row.querySelector('input[name$="[name]"]');
            return nameInput?.value.trim();
        });

        const newCombinations = validCombinations.filter(
            (combo) => !existingVariations.includes(combo.name)
        );

        newCombinations.forEach((combo, idx) => {
            const globalIndex =
                variationsContainer.getElementsByClassName(
                    "variation-row"
                ).length;
            const skuPrefix = variableSkuInput?.value.trim() || "VAR";
            const variationSku = `${skuPrefix}-${combo.name
                .toLowerCase()
                .replace(/\s+/g, "-")}`;

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

            row.querySelectorAll(
                'input[name$="[price]"], input[name$="[sale_price]"], input[name$="[sku]"], .variation-image-input'
            ).forEach((input) => {
                input.addEventListener("change", updateVariationsTable);
            });
        });

        variationsContainer.style.display =
            variationsContainer.children.length > 0 ? "block" : "none";
        variationsTableContainer.style.display =
            variationsContainer.children.length > 0 ? "block" : "none";
        updateVariationsTable();
    }

    if (generateVariationsBtn && attributesContainer && variationsContainer) {
        generateVariationsBtn.addEventListener("click", function () {
            updateVariations(
                attributesContainer,
                variationsContainer,
                variableSkuInput
            );
        });
    }

    // Xử lý xóa biến thể
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
                e.target.closest(".variation-row").remove();
                variationsContainer.style.display =
                    variationsContainer.children.length > 0 ? "block" : "none";
                variationsTableContainer.style.display =
                    variationsContainer.children.length > 0 ? "block" : "none";
                updateVariationsTable();
            }
        }
    });

    // Cập nhật bảng danh sách biến thể
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
            const imageInput = row.querySelector(".variation-image-input");

            const name = nameInput?.value || `Biến thể ${index + 1}`;
            const sku = skuInput?.value || "";
            const price = priceInput?.value
                ? Number(priceInput.value).toLocaleString("vi-VN")
                : "0";
            const salePrice = salePriceInput?.value
                ? Number(salePriceInput.value).toLocaleString("vi-VN")
                : "0";
            const quantity = quantityInput?.value || "0";
            const oldImage =
                imageInput?.dataset?.oldImage ||
                imageInput?.dataset?.imageUrl ||
                "";

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
            if (imageInput?.files?.[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.alt = "Ảnh biến thể";
                    img.className = "variation-image";
                    img.style.maxWidth = "50px";
                    img.style.maxHeight = "50px";
                    imageCell.innerHTML = "";
                    imageCell.appendChild(img);
                };
                reader.readAsDataURL(imageInput.files[0]);
            } else if (oldImage) {
                const img = document.createElement("img");
                img.src = oldImage;
                img.alt = "Ảnh biến thể";
                img.className = "variation-image";
                img.style.maxWidth = "50px";
                img.style.maxHeight = "50px";
                img.onerror = function () {
                    imageCell.textContent = "Ảnh không hợp lệ";
                };
                imageCell.innerHTML = "";
                imageCell.appendChild(img);
            } else {
                imageCell.textContent = "Không có ảnh";
            }
        });

        variationsTableContainer.style.display =
            variationRows.length > 0 ? "block" : "none";
    }

    // Thêm event cho image change
    document.querySelectorAll(".variation-image-input").forEach((input) => {
        input.addEventListener("change", updateVariationsTable);
    });

    // Xử lý submit form
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function (e) {
            const priceInput = form.querySelector('input[name="price"]');
            const salePriceInput = form.querySelector(
                'input[name="sale_price"]'
            );
            const variationPriceInputs = form.querySelectorAll(
                'input[name^="variations"][name$="[price]"]'
            );
            const variationSalePriceInputs = form.querySelectorAll(
                'input[name^="variations"][name$="[sale_price]"]'
            );

            let hasError = false;

            if (
                productType?.value === "simple" &&
                priceInput &&
                priceInput.value
            ) {
                let priceValue = priceInput.value.replace(",", ".").trim();
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

            [...variationPriceInputs, ...variationSalePriceInputs].forEach(
                (input) => {
                    if (input && input.value) {
                        let priceValue = input.value.replace(",", ".").trim();
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

            if (hasError) {
                e.preventDefault();
                alert("Vui lòng nhập giá hợp lệ (số dương).");
            }
        });
    });

    // Xử lý nút "Thêm giá gốc" cho tất cả biến thể
    if (setVariationsPriceBtn) {
        setVariationsPriceBtn.addEventListener("click", function () {
            const variationRows =
                variationsContainer.getElementsByClassName("variation-row");
            if (variationRows.length === 0) {
                alert("Chưa có biến thể nào để thêm giá gốc.");
                return;
            }

            let price;
            while (true) {
                price = prompt(
                    "Nhập giá gốc cho tất cả biến thể (VD: 1000 hoặc 1234.56):"
                );
                if (price === null) return;
                price = price.replace(",", ".").trim();
                if (
                    !price ||
                    isNaN(parseFloat(price)) ||
                    parseFloat(price) < 0
                ) {
                    alert("Vui lòng nhập giá gốc hợp lệ (số dương).");
                    continue;
                }
                break;
            }

            Array.from(variationRows).forEach((row) => {
                const priceInput = row.querySelector('input[name$="[price]"]');
                if (priceInput) {
                    priceInput.value = parseFloat(price).toString();
                    priceInput.classList.remove("is-invalid");
                }
            });
            updateVariationsTable();
        });
    }

    // Tùy chỉnh edit mode: ẩn nút thêm/xóa thuộc tính, tạo biến thể, disable select/checkbox
    if (isEditMode) {
        if (addAttributeBtn) addAttributeBtn.style.display = "none";
        if (generateVariationsBtn) generateVariationsBtn.style.display = "none";
        if (setVariationsPriceBtn) setVariationsPriceBtn.style.display = "none";
        document
            .querySelectorAll(
                ".remove-attribute, .remove-tag, .remove-variation"
            )
            .forEach((btn) => (btn.style.display = "none"));
        document
            .querySelectorAll(".attribute-type")
            .forEach((select) => (select.disabled = true));
        document
            .querySelectorAll(".attribute-value-checkbox")
            .forEach((cb) => (cb.disabled = true));
    }

    // Khởi tạo
    updateAddAttributeBtn();
    checkGenerateButton();
    updateVariationsTable();
});
