<?php
include("../vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

// 1. Login ဝင်ထားခြင်း ရှိမရှိ စစ်ဆေးခြင်း
$user = Auth::check();

// 2. Form မှ ဖိုင် တင်လာခြင်း ရှိမရှိ စစ်ဆေးခြင်း
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['photo'];
    $name = $file['name'];
    $tmp = $file['tmp_name'];
    
    // 3. Project ထဲရှိ photo/ ဖိုင်တွဲဆီသို့ ပုံကို ရွှေ့ပြောင်းခြင်း
    // (profile.php မှ _actions/ သို့ဝင်လာသောကြောင့် ../photo/ ဟု သုံးရပါမည်)
    $uploadDir = "../photo/";
    
    // photo/ ဖိုင်တွဲ မရှိသေးပါက အလိုအလျောက် ဖန်တီးပေးမည်
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $destination = $uploadDir . $name;

    if (move_uploaded_file($tmp, $destination)) {
        // 4. Database ထဲတွင် User ရဲ့ photo column ကို အသစ်လဲလှယ်ခြင်း
        $table = new UsersTable(new MySQL());
        $table->updatePhoto($user->id, $name);

        // 5. Session ထဲက user အချက်အလက်ကိုပါ ပုံအသစ်ဖြင့် update လုပ်ပေးပါ (Optional)
        $_SESSION['user']->photo = $name;

        // 6. Profile စာမျက်နှာသို့ ပြန်လည်ပို့ဆောင်ခြင်း
        HTTP::redirect("/profile.php");
    } else {
        // ပုံတင်မအောင်မြင်ပါက Error ဖြင့် ပြန်ပို့မည်
        HTTP::redirect("/profile.php", "error=upload_failed");
    }
} else {
    HTTP::redirect("/profile.php", "error=no_file");
}