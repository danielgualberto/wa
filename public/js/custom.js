// Here goes your custom javascript
function setCookie_lang(cookie_lang) {
    const setTime_expires = new Date();
    setTime_expires.setTime(setTime_expires.getTime() + (60*60*24*30*1000));
    document.cookie = 'lang='+cookie_lang+'; expires='+setTime_expires.toUTCString()+'; path=/';
    window.location.reload();
}
function getCookie_lang(cookie_lang) {
    let lang = cookie_lang + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(lang) === 0) {
            return c.substring(lang.length, c.length);
        }
    }
    return "";
}
$(function() {
    $('a[onclick="setCookie_lang(\''+getCookie_lang('lang')+'\')"]').addClass("active");
});

function textToClipboard(e) {
  let t = document.querySelector("#" + e).value;
  void 0 === t && (t = document.querySelector("#" + e).text),
  void 0 === t && (t = document.querySelector("#" + e).innerHTML),
  e = document.createElement("textarea"), document.body.appendChild(e), e.value = t, e.select(), document.execCommand("copy"), document.body.removeChild(e)
}

/* Dark Mode */
// const btn = document.querySelector(".btn-toggle-dark-mode");
// const currentTheme = localStorage.getItem("theme");
// if (currentTheme == "dark") {
//     document.body.classList.add("dark-theme");
//     btn.innerHTML = `<i class="material-icons-outlined">light_mode</i>`;
// }
// btn.addEventListener("click", function () {
//     document.body.classList.toggle("dark-theme");
//     let theme = "light";
//     btn.innerHTML = `<i class="material-icons-outlined">dark_mode</i>`;
//     if (document.body.classList.contains("dark-theme")) {
//         theme = "dark";
//         btn.innerHTML = `<i class="material-icons-outlined">light_mode</i>`;
//     }
//     localStorage.setItem("theme", theme);
// });
