document.addEventListener("DOMContentLoaded", function () {
    const productType = document.getElementById("product_type");
    const simpleProduct = document.getElementById("simple-product");
    const variableProduct = document.getElementById("variable-product");
    const attributesContainer = document.getElementById("attributes-container");
    const addAttributeBtn = document.getElementById("add-attribute");
    const generateVariationsBtn = document.getElementById(
        "generate-variations"
    );
    const variationsContainer = document.getElementById("variations-container");
    const variationsTableBody = document.getElementById(
        "variations-table-body"
    );


    // Danh sách màu sắc, kích thước, độ cận và độ loạn từ PHP
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

    // Xử lý chuyển đổi loại sản phẩm
    if (productType) {
        function toggleProductType() {
            if (productType.value === "simple") {
                simpleProduct.style.display = "block";
                variableProduct.style.display = "none";
            } else {
                simpleProduct.style.display = "none";
                variableProduct.style.display = "block";
            }
        }
        productType.addEventListener("change", toggleProductType);
        toggleProductType(); // Khởi tạo trạng thái ban đầu
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
                            `<option value="${t}">${t === "color"
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

                // Đồng bộ tag với checkbox
                const selectedValues = Array.from(
                    valuesContainer.querySelectorAll(
                        `input[name="attributes[${rowIndex}][values][]"]:checked`
                    )
                ).map((cb) => cb.value);
                tagsContainer.innerHTML = "";
                selectedValues.forEach((value) => {
                    let label = value;
                    if (selectedType === "color")
                        label =
                            colors.find((c) => c.id == value)?.name || value;
                    else if (selectedType === "size")
                        label = sizes.find((s) => s.id == value)?.name || value;
                    else if (selectedType === "spherical")
                        label =
                            spherical_values.find((s) => s.id == value)?.name ||
                            value;
                    else if (selectedType === "cylindrical")
                        label =
                            cylindrical_values.find((c) => c.id == value)
                                ?.name || value;

                    const tag = document.createElement("span");
                    tag.className = "tag";
                    tag.innerHTML = `${label}<input type="hidden" name="attributes[${rowIndex}][values][]" value="${value}"><button type="button" class="remove-tag" data-value="${value}">×</button>`;
                    tagsContainer.appendChild(tag);
                });
            }

            typeSelect.addEventListener("change", function () {
                const rowIndex =
                    this.closest(".attribute-row").getAttribute("data-index");
                updateValuesContainer(this.value, rowIndex);
                checkGenerateButton();
                updateAddAttributeBtn();
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
                        `<option value="${t}" ${t === currentType ? "selected" : ""
                        }>${t === "color"
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
            const valuesContainer = r.querySelector(
                ".attribute-values-container"
            );
            if (valuesContainer) {
                const selectedType = typeSelect.value;
                const options =
                    selectedType === "color"
                        ? colors
                        : selectedType === "size"
                            ? sizes
                            : selectedType === "spherical"
                                ? spherical_values
                                : cylindrical_values;

                const selectedValues = Array.from(
                    r.querySelectorAll(
                        `input[name="attributes[${rowIndex}][values][]"]:checked`
                    )
                ).map((cb) => cb.value);

                valuesContainer.innerHTML = "";
                if (options.length === 0) {
                    valuesContainer.innerHTML =
                        '<p class="text-muted">Không có giá trị nào để chọn.</p>';
                } else {
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
                                data-index="${rowIndex}"
                                ${selectedValues.includes(value)
                                ? "checked"
                                : ""
                            }>
                            <label class="form-check-label">${label}</label>
                        `;
                        valuesContainer.appendChild(div);
                    });
                }
            }
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
            variationsContainer.querySelectorAll("#variations-table-body tr").length > 0 ? "block" : "none";
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
            variationsContainer.querySelectorAll("#variations-table-body tr")
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
            return nameInput?.value.trim();
        });

        const newCombinations = validCombinations.filter(
            (combo) => !existingVariations.includes(combo.name)
        );

        if (!newCombinations.length) {
            alert("Không có tổ hợp biến thể mới để tạo.");
            return;
        }

        const newVariationRows = [];
        newCombinations.forEach((combo, idx) => {
            const globalIndex =
                variationsContainer.querySelectorAll("#variations-table-body tr").length;
            const skuPrefix = variableSkuInput?.value.trim() || "VAR";
            const randomId = Math.random().toString(36).substring(2, 10);
            const variationSku = `${skuPrefix}-${combo.name
                .toLowerCase()
                .replace(/\s+/g, "-")}-${randomId}`;

            const row = document.createElement("tr");
            row.className = "variation-row";
            row.setAttribute("data-new", "true"); // Đánh dấu biến thể mới

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
                <td>
                    <input type="text" name="variations[${globalIndex}][name]" value="${combo.name
                }" class="form-control" placeholder="Tên biến thể" readonly>
                    ${hiddenInputs.join("")}
                </td>
                <td>
                    <input type="text" name="variations[${globalIndex}][sku]" value="${variationSku}" class="form-control" placeholder="Mã sản phẩm">
                </td>
                <td>
                    <input type="text" class="form-control price-input" name="variations[${globalIndex}][price]" value="" placeholder="Nhập giá (VD: 1000)">
                </td>
                <td>
                    <input type="text" class="form-control price-input" name="variations[${globalIndex}][sale_price]" value="" placeholder="Nhập giá (VD: 900)">
                </td>
                <td>
                    <input type="number" class="form-control" name="variations[${globalIndex}][quantity]" value="0" min="0" placeholder="Nhập số lượng">
                </td>
                <td>
                    <input type="file" name="variations[${globalIndex}][image]" class="form-control variation-image-input">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-variation">Xóa</button>
                </td>
            `;
            variationsContainer.querySelector("#variations-table-body").appendChild(row);
            newVariationRows.push(row);

            row.querySelectorAll(
                'input[name$="[quantity]"], input[name$="[price]"], input[name$="[sale_price]"], input[name$="[sku]"]'
            ).forEach((input) => {
                input.addEventListener("input", () => {
                });
            });

            // Xử lý preview ảnh cho biến thể mới
            const imageInput = row.querySelector('input[name$="[image]"]');
            if (imageInput) {
                imageInput.addEventListener('change', function () {
                    const file = this.files[0];
                    let previewContainer = row.querySelector('.variation-image-preview');

                    // Xóa preview cũ nếu có
                    if (previewContainer) {
                        previewContainer.remove();
                    }

                    if (file) {
                        // Tạo preview mới
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewContainer = document.createElement('div');
                            previewContainer.className = 'variation-image-preview mt-2';
                            previewContainer.innerHTML = `
                                <img src="${e.target.result}"
                                     alt="Preview"
                                     class="variation-image"
                                     style="max-width: 50px; max-height: 50px; object-fit: cover; border-radius: 4px;">
                            `;
                            imageInput.parentNode.appendChild(previewContainer);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        variationsContainer.style.display =
            variationsContainer.querySelectorAll("#variations-table-body tr").length > 0 ? "block" : "none";

        if (newVariationRows.length > 0) {
            setTimeout(() => {
                showVariationsModal();
            }, 200);
        }
    }

    if (generateVariationsBtn && attributesContainer && variationsContainer) {
        generateVariationsBtn.addEventListener("click", function () {
            updateVariations(
                attributesContainer,
                variationsContainer,
                document.getElementById("variable_sku")
            );

        });
    }

    function showVariationsModal() {
        const modal = new bootstrap.Modal(document.getElementById('variationsModal'));
        modal.show();

        // Đăng ký event listener khi modal được hiển thị
        setTimeout(() => {
            const applyButton = document.getElementById('applyVariationsSettings');
            if (applyButton) {
                applyButton.onclick = function () {
                    console.log('Apply button clicked from modal');
                    const basePrice = document.getElementById('modalBasePrice').value.trim();
                    const salePrice = document.getElementById('modalSalePrice').value.trim();
                    const quantity = document.getElementById('modalQuantity').value.trim();

                    let hasError = false;
                    let errorMessage = '';

                    if (!basePrice) {
                        errorMessage += '- Vui lòng nhập giá gốc\n';
                        hasError = true;
                    } else {
                        const basePriceValue = parseFloat(basePrice.replace(',', '.'));
                        if (isNaN(basePriceValue) || basePriceValue < 0) {
                            errorMessage += '- Giá gốc phải là số dương\n';
                            hasError = true;
                        }
                    }

                    if (salePrice) {
                        const salePriceValue = parseFloat(salePrice.replace(',', '.'));
                        if (isNaN(salePriceValue) || salePriceValue < 0) {
                            errorMessage += '- Giá khuyến mãi phải là số dương\n';
                            hasError = true;
                        } else if (parseFloat(basePrice.replace(',', '.')) < salePriceValue) {
                            errorMessage += '- Giá khuyến mãi không được lớn hơn giá gốc\n';
                            hasError = true;
                        }
                    }

                    if (!quantity) {
                        errorMessage += '- Vui lòng nhập số lượng\n';
                        hasError = true;
                    } else {
                        const quantityValue = parseInt(quantity);
                        if (isNaN(quantityValue) || quantityValue < 1) {
                            errorMessage += '- Số lượng phải là số nguyên dương (ít nhất là 1)\n';
                            hasError = true;
                        }
                    }

                    if (hasError) {
                        alert('Có lỗi xảy ra:\n' + errorMessage);
                        return;
                    }

                    // Lưu giá trị để sử dụng trong modal xác nhận
                    window.tempModalValues = {
                        basePrice: basePrice,
                        salePrice: salePrice,
                        quantity: quantity
                    };

                    // Đóng modal nhập giá trị
                    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('variationsModal'));
                    modalInstance.hide();

                    // Hiển thị modal xác nhận
                    const confirmModal = new bootstrap.Modal(document.getElementById('confirmApplyModal'));
                    confirmModal.show();
                };
            }

            // Thêm validation real-time cho các input trong modal
            const modalBasePrice = document.getElementById('modalBasePrice');
            const modalSalePrice = document.getElementById('modalSalePrice');
            const modalQuantity = document.getElementById('modalQuantity');

            if (modalBasePrice) {
                modalBasePrice.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9,.]/g, '');
                });
            }

            if (modalSalePrice) {
                modalSalePrice.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9,.]/g, '');
                });
            }

            if (modalQuantity) {
                modalQuantity.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    // Không cho phép số 0 ở đầu
                    if (this.value === '0') {
                        this.value = '';
                    }
                });
            }

            // Thêm event listener cho việc click vào card
            const confirmModal = document.getElementById('confirmApplyModal');
            if (confirmModal) {
                const cards = confirmModal.querySelectorAll('.card');
                cards.forEach((card, index) => {
                    card.addEventListener('click', function () {
                        // Xóa highlight của tất cả card
                        cards.forEach(c => c.classList.remove('border-3'));
                        // Highlight card được chọn
                        this.classList.add('border-3');

                        // Áp dụng giá trị dựa trên card được chọn
                        if (index === 0) {
                            applyValuesToVariations(true); // Áp dụng cho tất cả
                        } else {
                            applyValuesToVariations(false); // Chỉ biến thể mới
                        }
                    });
                });
            }
        }, 100);
    }

    // Hàm áp dụng giá trị cho biến thể
    function applyValuesToVariations(applyToAll) {
        if (!window.tempModalValues) return;

        const { basePrice, salePrice, quantity } = window.tempModalValues;

        let targetRows;
        if (applyToAll) {
            // Áp dụng cho tất cả biến thể
            targetRows = variationsContainer.querySelectorAll("#variations-table-body tr");
        } else {
            // Chỉ áp dụng cho biến thể mới (có data-new="true")
            targetRows = variationsContainer.querySelectorAll("#variations-table-body tr[data-new='true']");
        }

        Array.from(targetRows).forEach((row) => {
            const priceInput = row.querySelector('input[name$="[price]"]');
            const salePriceInput = row.querySelector('input[name$="[sale_price]"]');
            const quantityInput = row.querySelector('input[name$="[quantity]"]');

            if (priceInput) priceInput.value = parseFloat(basePrice.replace(',', '.')).toString();
            if (salePriceInput) salePriceInput.value = salePrice ? parseFloat(salePrice.replace(',', '.')).toString() : '';
            if (quantityInput) quantityInput.value = quantity;
        });

        // Đóng modal xác nhận
        const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmApplyModal'));
        confirmModal.hide();

        // Reset form và xóa giá trị tạm
        document.getElementById('modalBasePrice').value = '';
        document.getElementById('modalSalePrice').value = '';
        document.getElementById('modalQuantity').value = '';
        window.tempModalValues = null;
    }



    if (variationsContainer) {
        const existingVariationRows =
            variationsContainer.querySelectorAll("#variations-table-body tr");
        Array.from(existingVariationRows).forEach((row) => {
            const quantityInput = row.querySelector(
                'input[name$="[quantity]"]'
            );
            const imageInput = row.querySelector('input[name$="[image]"]');
            if (quantityInput) {
                quantityInput.addEventListener("input", () => {
                });
            }
            if (imageInput) {
                imageInput.addEventListener("change", () => {
                });
            }
        });
    }

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-variation")) {
            const variationRows =
                variationsContainer.querySelectorAll("#variations-table-body tr");
            if (variationRows.length <= 1) {
                alert(
                    "Bạn không thể xóa biến thể này vì sản phẩm phải có ít nhất một biến thể."
                );
                return;
            }
            if (confirm("Bạn có chắc muốn xóa biến thể này?")) {
                e.target.closest("tr").remove();
                variationsContainer.style.display =
                    variationsContainer.querySelector("#variations-table-body tr").length > 0 ? "block" : "none";
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
                        `[name^="attributes[${idx}]"]`
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
                    if (isNaN(quantityValue) || quantityValue < 1) {
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
                    if (isNaN(quantityValue) || quantityValue < 1) {
                        input.classList.add("is-invalid");
                        hasError = true;
                    } else {
                        input.classList.remove("is-invalid");
                        input.value = quantityValue;
                    }
                }
            });

            if (hasError) {
                e.preventDefault();
                alert("Vui lòng nhập giá và số lượng hợp lệ (giá dương, số lượng ít nhất là 1).");
            }
        });
    });

    // Khởi tạo
    updateAddAttributeBtn();
    checkGenerateButton();

    // Xử lý preview ảnh cho biến thể
    const variationImageInputs = document.querySelectorAll('.variation-image-input');
    variationImageInputs.forEach(input => {
        input.addEventListener('change', function () {
            const file = this.files[0];
            const row = this.closest('tr');
            let previewContainer = row.querySelector('.variation-image-preview');

            // Xóa preview cũ nếu có
            if (previewContainer) {
                previewContainer.remove();
            }

            if (file) {
                // Tạo preview mới
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewContainer = document.createElement('div');
                    previewContainer.className = 'variation-image-preview mt-2';
                    previewContainer.innerHTML = `
                        <img src="${e.target.result}"
                             alt="Preview"
                             class="variation-image"
                             style="max-width: 50px; max-height: 50px; object-fit: cover; border-radius: 4px;">
                    `;
                    input.parentNode.appendChild(previewContainer);
                };
                reader.readAsDataURL(file);
            }
        });
    });
});
