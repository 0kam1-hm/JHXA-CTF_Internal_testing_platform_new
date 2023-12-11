/* 公告轮播 */
function noticeUp(obj,top,time) {
    $(obj).animate({
        marginTop: top
    }, time, function () {
        $(this).css({marginTop:"0"}).find(":first").appendTo(this);
    })
}
$(function () {
    setInterval("noticeUp('.peripheral ul','-35px',1000)", 3000);
});

/* 查看全部公告 */
function Infor(){
    document.getElementById("Informations").style.display = "block";
    document.getElementById("over").style.display = "block";
}
function hiden(){
    document.getElementById("Informations").style.display = "none";
    document.getElementById("over").style.display = "none";
}

function contents(objs,tops,times) {
    $(objs).animate({
        marginTop: tops
    }, times, function () {
        $(this).css({marginTop:"0"}).find(":first").appendTo(this);
    })
}
$(function () {
    setInterval("contents('.contents','-35px',1000)", 3000);
});







