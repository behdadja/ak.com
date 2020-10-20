
//گرفتن تاریخ به صورت فرمت
<input type="date" id="birthday" name="exam_date"   class="form-control birth-date" placeholder="1396/01/22" required="">
//***********************************************************************************************



//فراخوانی فایل اسکریپت و لینک در تابع مربوط به آن صفحه
$headerData['secondLinks'] = 'persian-calendar-links';
$footerData['secondScripts'] = 'persian-calendar-scripts';
//***********************************************************************************************



//تبدیل تاریخ شمسی به میلادی در آرایه جهت ذخیره در دیتابیس
$insert_array = array (
'birthday' => $this->calc->jalali_to_gregorian($birthday);
);
//***********************************************************************************************



//فرمت دهی در این پوت برای تاریخ
document.addEventListener('DOMContentLoaded', () => {
    for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
        const pattern = el.getAttribute("placeholder"),
            slots = new Set(el.dataset.slots || "_"),
            prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
            first = [...pattern].findIndex(c => slots.has(c)),
            accept = new RegExp(el.dataset.accept || "\\d", "g"),
            clean = input => {
                input = input.match(accept) || [];
                return Array.from(pattern, c =>
                    input[0] === c || slots.has(c) ? input.shift() || c : c
                );
            },
            format = () => {
                const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                    i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                    return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
                });
                el.value = clean(el.value).join``;
                el.setSelectionRange(i, j);
                back = false;
            };
        let back = false;
        el.addEventListener("keydown", (e) => back = e.key === "Backspace");
        el.addEventListener("input", format);
        el.addEventListener("focus", format);
        el.addEventListener("blur", () => el.value === pattern && (el.value=""));
    }
});

[data-slots] { font-family: monospace }

<label>Date time: 
    <input placeholder="dd/mm/yyyy hh:mm" data-slots="dmyh">
</label><br>
<label>Telephone:
    <input placeholder="+1 (___) ___-____" data-slots="_">
</label><br>
<label>MAC Address:
    <input placeholder="XX:XX:XX:XX:XX:XX" data-slots="X" data-accept="[\dA-H]">
</label><br>
<label>Signed number (3 digits):
    <input placeholder="±___" data-slots="±_" data-accept="^[+-]|(?!^)\d" size="4">
</label><br>
<label>Alphanumeric:
    <input placeholder="__-__-__-____" data-slots="_" data-accept="\w" size="13">
</label><br>
//***********************************************************************************************



//فرمت دهی در این پوت برای تاریخ
Array.prototype.forEach.call(document.body.querySelectorAll("*[data-mask]"), applyDataMask);

function applyDataMask(field) {
    var mask = field.dataset.mask.split('');
    
    // For now, this just strips everything that's not a number
    function stripMask(maskedData) {
        function isDigit(char) {
            return /\d/.test(char);
        }
        return maskedData.split('').filter(isDigit);
    }
    
    // Replace `_` characters with characters from `data`
    function applyMask(data) {
        return mask.map(function(char) {
            if (char != '_') return char;
            if (data.length == 0) return char;
            return data.shift();
        }).join('')
    }
    
    function reapplyMask(data) {
        return applyMask(stripMask(data));
    }
    
    function changed() {   
        var oldStart = field.selectionStart;
        var oldEnd = field.selectionEnd;
        
        field.value = reapplyMask(field.value);
        
        field.selectionStart = oldStart;
        field.selectionEnd = oldEnd;
    }
    
    field.addEventListener('click', changed)
    field.addEventListener('keyup', changed)
}

ISO Date: <input type="text" value="____-__-__" data-mask="____-__-__"/><br/>
Telephone: <input type="text" value="(___) ___-____" data-mask="(___) ___-____"/><br/>
//***********************************************************************************************
