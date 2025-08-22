# LUỒNG XỬ LÝ 4 PHẦN CHÍNH - KINHMATHA

## ** LUỒNG 1: QUẢN LÝ KHUYẾN MÃI (ADMIN) - @promotions/**

### **LUỒNG TẠO KHuyẾn MÃI:**
```
User nhập form → Validation → Lưu DB → Tạo relationships → Thành công
```

**Các case quan trọng:**
- **Case 1:** Tạo mã > 100% → Bị chặn bởi validation
- **Case 2:** Form có lỗi → Tự động khôi phục từ localStorage
- **Case 3:** Chọn loại giảm giá → Tự động thay đổi symbol và max value

### **LUỒNG FORM PERSISTENCE:**
```
User nhập → Auto-save localStorage → Lỗi validation → Restore → Chỉ sửa lỗi
```

---

## ** LUỒNG 2: LỊCH SỬ TRẠNG THÁI ĐƠN HÀNG (ADMIN) - @order_status_histories/**

### **LUỒNG CẬP NHẬT TRẠNG THÁI:**
```
Admin thay đổi → Lưu trạng thái cũ → Cập nhật mới → Ghi lịch sử
```

**Các case quan trọng:**
- **Case 1:** Thay đổi trạng thái → Ghi audit trail (ai, khi nào, từ đâu đến đâu)
- **Case 2:** Tìm kiếm → Theo mã đơn hàng, tên khách, trạng thái, thời gian
- **Case 3:** Phân trang → 20 records/trang, sắp xếp theo thời gian

### **LUỒNG HIỂN THỊ LỊCH SỬ:**
```
Query cơ bản → Áp dụng filter → Sắp xếp → Phân trang → Hiển thị
```

---

## ** LUỒNG 3: HIỂN THỊ KHUYẾN MÃI (CLIENT) - @voucher/**

### **LUỒNG HIỂN THỊ VOUCHER:**
```
Query voucher → Lọc theo điều kiện → Sắp xếp → Hiển thị
```

**Các case quan trọng:**
- **Case 1:** Voucher hết hạn → Không hiển thị, không cho áp dụng
- **Case 2:** Voucher chưa đến ngày → Không hiển thị
- **Case 3:** User đã dùng → Thông báo "Đã sử dụng rồi"
- **Case 4:** Hết lượt dùng → Thông báo "Hết lượt sử dụng"

### **LUỒNG ÁP DỤNG VOUCHER:**
```
User chọn → Kiểm tra điều kiện → Tính toán → Áp dụng vào giỏ hàng
```

**Các case quan trọng:**
- **Case 5:** Đơn hàng không đủ điều kiện → Min/max purchase
- **Case 6:** Discount > tổng đơn → Giới hạn = subtotal (bảo vệ doanh nghiệp)

---

## ** LUỒNG 4: SẢN PHẨM ĐÃ XEM GẦN ĐÂY (CLIENT) - @products/**

### **LUỒNG LƯU SẢN PHẨM (JAVASCRIPT):**
```
User xem sản phẩm → Đọc cookie → Loại bỏ trùng → Thêm mới → Lưu cookie
```

**Các case quan trọng:**
- **Case 1:** Xem lần đầu → Tạo cookie mới
- **Case 2:** Xem lại sản phẩm → Loại bỏ khỏi danh sách, thêm vào đầu
- **Case 3:** Quá 8 sản phẩm → Chỉ giữ 8 sản phẩm gần nhất
- **Case 4:** Cookie hết hạn → Tự động xóa sau 30 ngày

### **LUỒNG HIỂN THỊ (PHP):**
```
Đọc cookie → Parse JSON → Loại bỏ hiện tại → Query DB → Sắp xếp → Hiển thị
```

**Các case quan trọng:**
- **Case 5:** Không có cookie → Không hiển thị gì
- **Case 6:** Sản phẩm đã bị xóa → Bỏ qua, không lỗi
- **Case 7:** Hiển thị tối đa 4 sản phẩm → Tối ưu giao diện

---

## ** ĐIỂM QUAN TRỌNG KHI THI:**

### **1. BẢO VỆ DOANH NGHIỆP:**
- Validation nghiêm ngặt, không cho discount > 100%
- Kiểm tra điều kiện áp dụng voucher
- Giới hạn discount không vượt quá tổng đơn hàng

### **2. UX TỐT:**
- localStorage để không mất dữ liệu form
- Cookie để lưu sản phẩm đã xem
- Auto-save và restore dữ liệu

### **3. AUDIT TRAIL:**
- Ghi lại mọi thay đổi trạng thái đơn hàng
- Lưu thông tin ai thay đổi, khi nào, từ đâu đến đâu
- Tìm kiếm và lọc theo nhiều tiêu chí

### **4. PERFORMANCE:**
- Eager loading để tránh N+1 query
- Phân trang để tối ưu hiệu suất
- Giới hạn số lượng sản phẩm đã xem

### **5. SECURITY:**
- Kiểm tra điều kiện áp dụng voucher
- Validate dữ liệu đầu vào
- Kiểm tra quyền truy cập

---

## ** CÂU HỎI THI THƯỜNG GẶP:**

### **Q1: "Bạn validate discount như thế nào?"**
**Trả lời:** 
- Có 2 loại validation: Laravel rules và custom function
- Custom function kiểm tra: nếu là percentage thì không được > 100%
- JavaScript cũng tự động thay đổi max attribute theo loại

### **Q2: "Tại sao cần localStorage?"**
**Trả lời:** 
- User không mất dữ liệu khi có lỗi validation
- Không cần nhập lại từ đầu khi form reload
- Cải thiện UX đáng kể

### **Q3: "Logic bảo vệ doanh nghiệp là gì?"**
**Trả lời:** 
- Ngăn chặn tạo mã giảm giá > 100%
- Validation ở cả server (Laravel) và client (JavaScript)
- Logic kinh doanh: min < max purchase, end_date > start_date

### **Q4: "Làm sao để client chỉ thấy voucher còn hiệu lực?"**
**Trả lời:** 
- Query với điều kiện: `is_active = true`
- Kiểm tra thời gian: `start_date <= now() AND end_date >= now()`
- Sắp xếp theo `end_date ASC` (hết hạn gần nhất lên đầu)

### **Q5: "Tính năng 'Sản phẩm đã xem gần đây' hoạt động như thế nào?"**
**Trả lời:** 
- Lưu vào cookie khi user xem sản phẩm
- Loại bỏ trùng lặp, thêm vào đầu danh sách
- Giới hạn 8 sản phẩm, sắp xếp theo thời gian xem
- Tự động cập nhật hiển thị

---

## ** KHI THI, BẠN CÓ THỂ TRẢ LỜI:**

**"Tôi đã làm 4 phần chính:**

1. **Quản lý khuyến mãi (Admin):** Validation nghiêm ngặt, bảo vệ doanh nghiệp, localStorage để cải thiện UX
2. **Lịch sử trạng thái đơn hàng (Admin):** Audit trail, tìm kiếm theo nhiều tiêu chí
3. **Hiển thị khuyến mãi (Client):** Chỉ hiển thị voucher còn hiệu lực, áp dụng an toàn
4. **Sản phẩm đã xem gần đây (Client):** Cookie, sắp xếp theo thời gian, giới hạn 8 sản phẩm

**Mỗi phần đều có logic bảo vệ doanh nghiệp và cải thiện UX!"**

---

**File này đã lưu đầy đủ 4 luồng và các case quan trọng để bạn ôn thi! 🎯**
