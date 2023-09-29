</td>

<td width="300px" class="sidebar">
    <div class="sidebarHeader">Меню</div>
    <ul>
        <li><a href="/www/index.php/main">Главная страница</a></li>
        <li><a href="/about-me">Обо мне</a></li>
        <li><a href="/www/articles/create">Создать статью</a></li>
        <?php if (!empty($user)) { ?>
            <li><a href="/www/users/account">Личный кабинет</a></li> <?php } ?>
    </ul>
</td>
</tr>
<tr>
    <td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
</tr>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>
</html>