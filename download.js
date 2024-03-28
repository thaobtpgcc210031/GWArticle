

document.getElementById("downloadButton").addEventListener("click", function() {
    // Tên tệp tin muốn tải xuống
    var fileName = "example.txt";
    // Nội dung của tệp tin
    var fileContent = "This is an example file. Replace this content with your own.";

    // Tạo một đối tượng Blob chứa nội dung
    var blob = new Blob([fileContent], { type: "text/plain" });

    // Kiểm tra nếu trình duyệt là IE hoặc Edge
    if (window.navigator && window.navigator.msSaveOrOpenBlob) {
        window.navigator.msSaveOrOpenBlob(blob, fileName);
    } else {
        // Tạo một URL đại diện cho đối tượng Blob
        var url = URL.createObjectURL(blob);

        // Tạo một phần tử a để tạo ra một liên kết tải xuống
        var a = document.createElement("a");
        a.href = url;
        a.download = fileName;

        // Thêm phần tử a vào trang và kích hoạt sự kiện nhấp vào
        document.body.appendChild(a);
        a.click();

        // Xóa URL sau khi đã sử dụng xong
        window.URL.revokeObjectURL(url);
    }
});
