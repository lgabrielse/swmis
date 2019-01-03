$(function () {
    $.post("rrpowered-autosave.php", function (data) {
        $("[name='medrecnum']").val(data.medrecnum);
        $("[name='visitid']").val(data.visitid);
        $("[name='notes']").val(data.notes);
        $("[name='temp']").val(data.temp);
        $("[name='pulse']").val(data.pulse);
        $("[name='bp_sys']").val(data.bp_sys);
        $("[name='bp_dia']").val(data.bp_dia);
        $("[name='entryby']").val(data.entryby);
        $("[name='entrydt']").val(data.entrydt);
    }, "json");
    setInterval(function () {
        $.post("rrpowered-autosave.php", $("formpn1").serialize());
    }, 2000);
});// JavaScript Document

