document.addEventListener('DOMContentLoaded', function () {
    const productType = document.getElementById('product_type');
    const simpleProduct = document.getElementById('simple-product');
    const variableProduct = document.getElementById('variable-product');
    const nameInput = document.getElementById('name');
    const simpleSkuInput = document.getElementById('simple_sku');
    const variableSkuInput = document.getElementById('variable_sku');
    const simpleSlugInput = document.getElementById('simple_slug');
    const variableSlugInput = document.getElementById('variable_slug');
    const simpleStockQuantityInput = document.getElementById('simple_stock_quantity');
    const variableStockQuantityInput = document.getElementById('variable_stock_quantity');
    const attributesContainer = document.getElementById('attributes-container');
    const addAttributeBtn = document.getElementById('add-attribute');
    const generateVariationsBtn = document.getElementById('generate-variations');
    const variationsContainer = document.getElementById('variations-container');

    // Danh sách màu sắc và kích thước từ PHP (chỉ áp dụng cho create)
    const colors = window.colors || [];
    const sizes = window.sizes || [];

    console.log('Colors loaded:', colors); // Debug: Kiểm tra dữ liệu colors
    console.log('Sizes loaded:', sizes);   // Debug: Kiểm tra dữ liệu sizes

    // Tự động sinh SKU và Slug (chỉ áp dụng cho create)
    function generateSkuAndSlug(name, prefix = '') {
        const timestamp = Date.now();
        const sku = `${prefix}${name.toLowerCase().replace(/\s+/g, '-')}-${timestamp}`;
        const slug = `${prefix}${name.toLowerCase().replace(/\s+/g, '-')}-${timestamp}`;
        return { sku, slug };
    }

    if (nameInput && simpleSkuInput && simpleSlugInput && variableSkuInput && variableSlugInput) {
        nameInput.addEventListener('input', function () {
            const { sku, slug } = generateSkuAndSlug(this.value);
            simpleSkuInput.value = sku;
            simpleSlugInput.value = slug;
            variableSkuInput.value = `VAR-${sku}`;
            variableSlugInput.value = `var-${slug}`;
        });
    }

    // Khởi tạo trạng thái ban đầu dựa trên product_type
    if (productType) {
        if (productType.value === 'simple') {
            simpleProduct.style.display = 'block';
            variableProduct.style.display = 'none';
        } else {
            simpleProduct.style.display = 'none';
            variableProduct.style.display = 'block';
            if (nameInput && variableSkuInput && variableSlugInput) {
                const { sku, slug } = generateSkuAndSlug(nameInput.value, 'VAR-');
                variableSkuInput.value = sku;
                variableSlugInput.value = `var-${slug}`;
            }
        }

        productType.addEventListener('change', function () {
            const stockValue = simpleStockQuantityInput?.value || variableStockQuantityInput?.value || '0';
            if (this.value === 'simple') {
                simpleProduct.style.display = 'block';
                variableProduct.style.display = 'none';
                if (simpleStockQuantityInput) simpleStockQuantityInput.value = stockValue;
            } else {
                simpleProduct.style.display = 'none';
                variableProduct.style.display = 'block';
                if (variableStockQuantityInput) variableStockQuantityInput.value = stockValue;
                if (nameInput && variableSkuInput && variableSlugInput) {
                    const { sku, slug } = generateSkuAndSlug(nameInput.value, 'VAR-');
                    variableSkuInput.value = sku;
                    variableSlugInput.value = `var-${slug}`;
                }
            }
        });
    }

    // Đặt giá trị mặc định cho stock_quantity
    [simpleStockQuantityInput, variableStockQuantityInput].forEach(input => {
        if (input) {
            input.addEventListener('blur', function () {
                if (!this.value || isNaN(parseInt(this.value)) || parseInt(this.value) < 0) {
                    this.value = '0';
                    console.log(`Set ${this.id} to default: 0`);
                }
            });
        }
    });

    // Xử lý định dạng giá trị số
    document.querySelectorAll('.price-input').forEach(input => {
        input.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^0-9,.]/g, '');
            if (value.includes(',')) value = value.replace(',', '.');
            if (value.split('.').length > 2) value = value.replace(/\.+$/, '');
            e.target.value = value;
        });

        input.addEventListener('blur', function (e) {
            if (e.target.value === '') {
                e.target.value = '0';
                console.log('Set price/sale_price to default: 0');
            }
        });
    });

    // Xử lý thêm thuộc tính (chỉ áp dụng cho create)
    if (addAttributeBtn) {
        addAttributeBtn.addEventListener('click', function () {
            const attributeRows = attributesContainer.getElementsByClassName('attribute-row');
            if (attributeRows.length >= 2) {
                addAttributeBtn.style.display = 'none';
                return;
            }

            const existingTypes = Array.from(attributeRows).map(row => row.querySelector('.attribute-type').value);
            const index = attributeRows.length;
            const row = document.createElement('div');
            row.className = 'attribute-row row g-2 mb-2';
            row.innerHTML = `
                <div class="col-md-3">
                    <select name="attributes[${index}][type]" class="form-select attribute-type" data-index="${index}">
                        ${existingTypes.includes('color') ? '<option value="size">Kích thước</option>' : '<option value="color">Màu sắc</option>'}
                        ${!existingTypes.includes('size') && !existingTypes.includes('color') ? '<option value="size">Kích thước</option>' : ''}
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

            const typeSelect = row.querySelector('.attribute-type');
            const tagsContainer = row.querySelector('.attribute-values-tags');
            const valuesContainer = row.querySelector('.attribute-values-container');

            typeSelect.addEventListener('change', function () {
                tagsContainer.innerHTML = '';
                valuesContainer.innerHTML = '';
                const options = this.value === 'color' ? colors : sizes;
                if (options && options.length > 0) {
                    options.forEach(option => {
                        const div = document.createElement('div');
                        div.className = 'form-check';
                        div.innerHTML = `
                            <input type="checkbox" class="form-check-input attribute-value-checkbox" name="attributes[${index}][values][]" value="${option}" data-index="${index}">
                            <label class="form-check-label">${option}</label>
                        `;
                        valuesContainer.appendChild(div);
                    });
                    console.log(`Loaded ${this.value === 'color' ? colors.length : sizes.length} options for ${this.value}`);
                } else {
                    console.error(`No data available for ${this.value === 'color' ? 'colors' : 'sizes'}`);
                }
            });

            valuesContainer.addEventListener('change', function (e) {
                if (e.target.classList.contains('attribute-value-checkbox')) {
                    const index = e.target.getAttribute('data-index');
                    const selectedValues = Array.from(valuesContainer.querySelectorAll('input[name="attributes[' + index + '][values][]"]:checked')).map(checkbox => checkbox.value);
                    tagsContainer.innerHTML = '';
                    selectedValues.forEach(value => {
                        const tag = document.createElement('span');
                        tag.className = 'tag';
                        tag.innerHTML = `${value}<input type="hidden" name="attributes[${index}][values][]" value="${value}"><button type="button" class="remove-tag" data-value="${value}">×</button>`;
                        tagsContainer.appendChild(tag);
                    });
                    checkGenerateButton();
                    updateAddAttributeBtn();
                }
            });

            tagsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-tag')) {
                    const value = e.target.getAttribute('data-value');
                    const checkbox = valuesContainer.querySelector(`input[value="${value}"]`);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                    e.target.parentElement.remove();
                    checkGenerateButton();
                    updateAddAttributeBtn();
                }
            });

            row.querySelector('.remove-attribute').addEventListener('click', function () {
                row.remove();
                checkGenerateButton();
                updateAddAttributeBtn();
            });

            typeSelect.dispatchEvent(new Event('change')); // Kích hoạt sự kiện change để load giá trị ngay lập tức
            updateAddAttributeBtn();
        });
    }

    function updateAddAttributeBtn() {
        if (!attributesContainer) return;
        const attributeRows = attributesContainer.getElementsByClassName('attribute-row');
        const types = Array.from(attributeRows).map(row => row.querySelector('.attribute-type').value);
        if (attributeRows.length >= 2 || (types.includes('color') && types.includes('size'))) {
            addAttributeBtn.style.display = 'none';
        } else {
            addAttributeBtn.style.display = attributeRows.length < 2 ? 'block' : 'none';
        }
    }

    function checkGenerateButton() {
        if (!attributesContainer) return;
        const attributeRows = attributesContainer.getElementsByClassName('attribute-row');
        let hasValues = false;
        for (let row of attributeRows) {
            const tags = row.querySelectorAll('.tag');
            if (tags.length > 0) {
                hasValues = true;
                break;
            }
        }
        if (hasValues) {
            generateVariationsBtn.style.display = 'block';
        } else {
            generateVariationsBtn.style.display = 'none';
            variationsContainer.style.display = 'none';
            variationsContainer.innerHTML = '';
        }
    }

    function generateCombinations(attributes) {
        if (attributes.length === 0) return [[]];
        const first = attributes[0];
        const rest = attributes.slice(1);
        const combinationsOfRest = generateCombinations(rest);
        const result = [];
        for (let val of first.values) {
            for (let combo of combinationsOfRest) {
                result.push([val, ...combo]);
            }
        }
        return result;
    }

    if (generateVariationsBtn) {
        generateVariationsBtn.addEventListener('click', function () {
            const attributeRows = attributesContainer.getElementsByClassName('attribute-row');
            const attributes = [];
            for (let row of attributeRows) {
                const type = row.querySelector('.attribute-type').value;
                const tags = row.querySelectorAll('.tag');
                const values = Array.from(tags).map(tag => tag.querySelector('input').value);
                if (values.length === 0) continue;
                attributes.push({ type, values });
            }

            if (attributes.length === 0) {
                alert('Vui lòng chọn ít nhất một giá trị cho một thuộc tính.');
                return;
            }

            const combinations = generateCombinations(attributes);

            variationsContainer.style.display = 'block';
            variationsContainer.innerHTML = '';
            combinations.forEach((combo, index) => {
                const row = document.createElement('div');
                row.className = 'variation-row row g-2 mb-2';
                const skuPrefix = variableSkuInput.value;
                const comboName = combo.join(' - ');
                row.innerHTML = `
                    <div class="col-md-2">
                        <input type="text" name="variations[${index}][name]" value="${comboName}" class="form-control" placeholder="Tên biến thể" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="variations[${index}][sku]" value="${skuPrefix}-${comboName.toLowerCase().replace(/\s+/g, '-')}" class="form-control" placeholder="Mã sản phẩm">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control price-input" name="variations[${index}][price]" value="" placeholder="Nhập giá (VD: 1000 hoặc 1.234,56)">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control price-input" name="variations[${index}][sale_price]" value="" placeholder="Nhập giá (VD: 900 hoặc 1.234,56)">
                    </div>
                    <div class="col-md-1">
                        <input type="number" name="variations[${index}][stock_quantity]" value="0" class="form-control stock-quantity-input" placeholder="Tồn kho" min="0">
                    </div>
                    <div class="col-md-1">
                        <select name="variations[${index}][status]" class="form-select variation-status">
                            <option value="in_stock">Còn hàng</option>
                            <option value="out_of_stock" selected>Hết hàng</option>
                            <option value="hidden">Ẩn</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ảnh biến thể</label>
                        <input type="file" name="variations[${index}][image]" class="form-control variation-image-input" style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-variation">Xóa</button>
                    </div>
                `;
                variationsContainer.appendChild(row);

                // Thêm sự kiện cho stock_quantity để tự động cập nhật trạng thái
                const stockInput = row.querySelector('.stock-quantity-input');
                const statusSelect = row.querySelector('.variation-status');
                stockInput.addEventListener('input', function () {
                    if (parseInt(this.value) === 0) {
                        statusSelect.value = 'out_of_stock';
                    } else if (statusSelect.value === 'out_of_stock') {
                        statusSelect.value = 'in_stock';
                    }
                });

                row.querySelector('.remove-variation').addEventListener('click', function () {
                    row.remove();
                });
            });
        });
    }

    // Xử lý submit form
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const priceInput = form.querySelector('input[name="price"]');
            const salePriceInput = form.querySelector('input[name="sale_price"]');
            const variationPriceInputs = form.querySelectorAll('input[name^="variations"][name$="[price]"]');
            const variationSalePriceInputs = form.querySelectorAll('input[name^="variations"][name$="[sale_price]"]');
            const stockQuantityInput = productType?.value === 'simple' ? simpleStockQuantityInput : variableStockQuantityInput;

            let hasError = false;

            if (stockQuantityInput && (!stockQuantityInput.value || isNaN(parseInt(stockQuantityInput.value)) || parseInt(stockQuantityInput.value) < 0)) {
                stockQuantityInput.value = '0';
                console.log('Set stock_quantity to default on submit: 0');
            } else if (stockQuantityInput) {
                stockQuantityInput.value = parseInt(stockQuantityInput.value).toString();
                console.log('Stock quantity after validation:', stockQuantityInput.value);
            }

            if (productType?.value === 'simple' && priceInput && priceInput.value) {
                let priceValue = priceInput.value.replace(',', '.');
                if (isNaN(parseFloat(priceValue)) || parseFloat(priceValue) < 0) {
                    priceInput.classList.add('is-invalid');
                    hasError = true;
                } else {
                    priceInput.classList.remove('is-invalid');
                    priceInput.value = parseFloat(priceValue).toString();
                }
            }

            [salePriceInput, ...variationPriceInputs, ...variationSalePriceInputs].forEach(input => {
                if (input && input.value) {
                    let priceValue = input.value.replace(',', '.');
                    if (isNaN(parseFloat(priceValue)) || parseFloat(priceValue) < 0) {
                        input.classList.add('is-invalid');
                        hasError = true;
                    } else {
                        input.classList.remove('is-invalid');
                        input.value = parseFloat(priceValue).toString();
                    }
                }
            });

            console.log('Form data before submit:', {
                product_type: productType?.value,
                stock_quantity: stockQuantityInput?.value,
                price: priceInput?.value,
                sale_price: salePriceInput?.value,
            });

            if (hasError) {
                e.preventDefault();
                alert('Vui lòng nhập số lượng tồn kho và giá hợp lệ (số dương).');
            }
        });
    });

    updateAddAttributeBtn();

    // Khởi tạo sự kiện cho các checkbox hiện có
    document.querySelectorAll('.attribute-value-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const index = this.getAttribute('data-index');
            const container = this.closest('.attribute-row');
            const tagsContainer = container.querySelector('.attribute-values-tags');
            const selectedValues = Array.from(container.querySelectorAll(`input[name="attributes[${index}][values][]"]:checked`)).map(checkbox => checkbox.value);
            tagsContainer.innerHTML = '';
            selectedValues.forEach(value => {
                const tag = document.createElement('span');
                tag.className = 'tag';
                tag.innerHTML = `${value}<input type="hidden" name="attributes[${index}][values][]" value="${value}"><button type="button" class="remove-tag" data-value="${value}">×</button>`;
                tagsContainer.appendChild(tag);
            });
            checkGenerateButton();
            updateAddAttributeBtn();
        });
    });

    // Khởi tạo sự kiện xóa tag cho các tag hiện có
    document.querySelectorAll('.attribute-values-tags').forEach(tagsContainer => {
        tagsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-tag')) {
                const value = e.target.getAttribute('data-value');
                const container = e.target.closest('.attribute-row');
                const checkbox = container.querySelector(`input[value="${value}"]`);
                if (checkbox) {
                    checkbox.checked = false;
                }
                e.target.parentElement.remove();
                checkGenerateButton();
                updateAddAttributeBtn();
            }
        });
    });

    // Khởi tạo sự kiện cho stock_quantity để tự động cập nhật trạng thái (cho các variation hiện có)
    document.querySelectorAll('.stock-quantity-input').forEach(input => {
        input.addEventListener('input', function () {
            const row = this.closest('.variation-row');
            const statusSelect = row.querySelector('.variation-status');
            if (parseInt(this.value) === 0) {
                statusSelect.value = 'out_of_stock';
            } else if (statusSelect.value === 'out_of_stock') {
                statusSelect.value = 'in_stock';
            }
        });
    });
});
