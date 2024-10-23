import {
  mbNotification,
  mbConfirm,
  mbLoading,
  mbFetch,
  mbPagination,
  mbFormData,
} from "../allmodule.js";

const allCookies = document.cookie;
console.log(allCookies);
// dùng để hiển thị ra template trước khi gọi tới DOM
const divRoot = document.getElementById("root");
const templateroot = `
      <div class="container1">
        <form class="grid" id="form">
            <!-- Student Information -->
            <div>
                <h2>Student Information</h2>
                <input type="text" value="" hidden name="id_account">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="" name="email" readonly>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="">
                </div>
                <div class="form-group">
                    <label>Date created</label>
                    <input type="text" value="" name="createdat" readonly>
                </div>
            </div>
            <!-- License Information -->
            <div>
                <h2>License Information</h2>
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" value="FPL.SPRING2024.AF8F97339C6D6AF0746FAA7F146932A4" readonly>
                </div>
                <div class="form-group">
                    <label>Book</label>
                    <input type="text" value="American Anh Ngu Mb Level 99+" readonly>
                </div>
                <div class="form-group">
                    <label>Status: <x style="color: green; font-weight: 600;">Active</x></label>
                </div>
                <hr>
            </div>
        </form>
        <hr>
        <div class="btn-bt">
          <button class="btn-change">Change Password</button>
          <button class="btn-save">Save</button>
          <button class="btn-cancel">Cancel</button>
      </div>

    </div>
        <div class="dv-edit-class-container"></div>
    `;
divRoot.innerHTML = templateroot;
async function fetAccount() {
  const url = "admin/profile/getaccount";
  try {
    const accountData = await mbFetch(url);  // Giả sử mbFetch trả về dữ liệu tài khoản
    console.log(accountData);
    if (accountData.error) {
      console.error("Error fetching account data:", accountData.error);
      mbNotification("Error", "Failed to fetch account data", 3);
    } else {
      // Cập nhật giá trị của các trường input trong giao diện
      document.querySelector('.form-group input[name="name"]').value = accountData.fullName;
      document.querySelector('.form-group input[name="email"]').value = accountData.email;
      document.querySelector('.form-group input[name="createdat"]').value = accountData.createdAt;
      document.querySelector('input[name="id_account"]').value = accountData.id;
    }
  } catch (err) {
    console.error("Error fetching account:", err);
    mbNotification("Error", "Failed to fetch account data", 3);
  }
}
fetAccount();

const saveButton = document.querySelector(".btn-save");

saveButton.addEventListener("click", async function (e) {
  e.preventDefault();
  const nameInput = document.querySelector('.form-group input[name="name"]');
  const accountInput = document.querySelector('input[name="id_account"]');
  const name = nameInput.value;
  const id = accountInput.value;
  const formData = {
    name: name,
    id: id,
  };
  console.log(formData);
  try {
    const updateResponse = await mbFetch("admin/profile/updateAccount", formData);  // Gửi yêu cầu cập nhật
    console.log("Update response:", updateResponse); 
    if (updateResponse.error) {
      mbNotification("Error", updateResponse.error, 3);
    } else {
      mbNotification("Success", "Account updated successfully", 1);

      // Cập nhật giao diện
      nameInput.value = updateResponse.fullName;

      // Cập nhật ảnh đại diện nếu người dùng đã chọn ảnh mới
      if (updateResponse.profileImage) {
        const imgPreview = document.querySelector('.form-group img');
        imgPreview.src = updateResponse.profileImage;  // Cập nhật ảnh đại diện
      }
    }
  } catch (err) {
    console.error("Error updating account:", err);
    mbNotification("Error", "Failed to update account", 3);
  }
});
// function showFormChangePassword(data){
//   return new Promise((resolve) => {
//     const box = document.querySelector(".dv-edit-class-container");
//     const boxcontent = document.querySelect
//   });
// };