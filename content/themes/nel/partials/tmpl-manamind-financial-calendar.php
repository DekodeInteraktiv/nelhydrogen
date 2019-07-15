<?php
// Financial calendar
?>
<script type="text/html" id="<?php echo $feed['tmpl']; ?>">
    <%
    var data = manamind[1].financialCalendar;
    for (var i=0; i
    <data.date.length; i++) {
    var event = {
    date: data.date[i].text,
    text: data.text[i].text,
    type: data.type[i].text,
    };
    %>
    <div class="event">
        <span class="strong"><%=event.text%></span>
        <p data-filter="strtotime"><%=event.date%></p>
    </div>
    <%
    }
    %>
</script>