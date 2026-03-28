function cookieToJson(cookieString) {
    if (!cookieString || typeof cookieString !== 'string') {
        return {};
    }
    const cookies = cookieString.split(';');
    const result = {};
    for (const cookie of cookies) {
        if (!cookie.trim()) {
            continue;
        }
        const equalsIndex = cookie.indexOf('=');
        if (equalsIndex === -1) {
            continue;
        }
        const name = cookie.substring(0, equalsIndex).trim();
        let value = cookie.substring(equalsIndex + 1).trim();
        try {
            value = decodeURIComponent(value);
        } catch (e) {
            console.warn(`Failed to decode cookie value: ${value}`, e);
        }
        result[name] = value;
    }
    return result;
}

$(function() {
    checkLoginStatus();
    getNewList();
});

function checkLoginStatus() {
    const cookie = cookieToJson(document.cookie);
    const username = cookie.username;
    const role = cookie.role;
    
    if (username && role) {
        // 用户已登录
        $('#loginButton').hide();
        $('#userMenu').show();
        $('#usernameDisplay').text(username);
        $('#userAvatar').text(username.charAt(0).toUpperCase());
    } else {
        // 用户未登录
        $('#loginButton').show();
        $('#userMenu').hide();
    }
}

function openModal() {
    const cookie = cookieToJson(document.cookie);
    const userId = cookie.uid;
    console.log('用户ID:', userId);
    console.log('Cookie信息:', cookie);
    
    if (userId) {
        $.ajax({
            type: "get",
            url: "http://www.new.com:8081/getUserById.php",
            data: { id: userId },
            dataType: "json",
            success: function(result) {
                console.log('获取用户信息成功:', result);
                if (result.code == 200) {
                    const userInfo = result.data[0];
                    $('#modalUsername').text(userInfo.username);
                    $('#modalRole').text(userInfo.role);
                    $('#infoUsername').text(userInfo.username);
                    $('#infoRole').text(userInfo.role);
                    $('#infoLoginTime').text(new Date().toLocaleString());
                    $('#modalAvatar').text(userInfo.username.charAt(0).toUpperCase());
                    $('#profileModal').addClass('active');
                } else {
                    alert(result.msg);
                }
            },
            error: function(xhr, status, error) {
                console.error('查询个人信息失败:', status, error);
                alert('查询个人信息失败');
            }
        });
    } else {
        alert('请先登录');
    }
}

function closeModal() {
    $('#profileModal').removeClass('active');
}

function getNewList() {
    $.ajax({
        type: "get",
        url: "http://www.new.com:8081/getNewList.php",
        data: { search: "" },
        dataType: "json",
        success: function(result) {
            if (result.code == 200) {
                let content = '';
                for (const item of result.data) {
                    let summary = item.content.length > 100 ? item.content.substring(0, 100) + '...' : item.content;
                    let title = item.title.length > 20 ? item.title.substring(0, 20) + '...' : item.title;
                    content += `
                    <tr>
                        <td><span style="background: linear-gradient(135deg, #2563eb, #7c3aed); color: white; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 12px;">#${item.id}</span></td>
                        <td>
                            <a href="./news_detail.html?nid=${item.id}" class="news-title-link" style="display: block; font-weight: 600; color: #1e293b; font-size: 15px; line-height: 1.4;">${title}</a>
                        </td>
                        <td class="news-summary" style="color: #64748b; font-size: 14px; line-height: 1.6;">${summary}</td>
                        <td class="news-time" style="color: #94a3b8; font-size: 13px; font-weight: 500;">${item.newTime}</td>
                        <td style="text-align: center;">
                            <a href="./news_detail.html?nid=${item.id}" class="view-news-btn" style="display: inline-block; padding: 8px 16px; background: linear-gradient(135deg, #2563eb, #7c3aed); color: white; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.3s;">👁️ 查看</a>
                        </td>
                    </tr>
                    `;
                }
                $('#newsTableBody').html(content);
            } else if (result.code == 402) {
                $('#newsTableBody').html('<tr><td colspan="5" style="text-align:center; padding:60px 20px; color:#94a3b8; font-size: 15px;"><div style="font-size: 48px; margin-bottom: 16px;">📭</div><div>暂无新闻数据</div></td></tr>');
            } else {
                alert(result.msg);
            }
        },
        error: function() {
            alert('获取新闻列表失败');
        }
    });
}

function logout() {
    $.ajax({
        type: "get",
        url: "http://www.new.com:8081/logout.php",
        dataType: "json",
        xhrFields: { withCredentials: true },
        success: function(result) {
            if (result.code == 200) {
                alert(result.msg);
                location.reload();
            }
        },
        error: function() {
            alert('AJAX请求失败');
        }
    });
}

// 点击用户菜单打开模态框
$(document).on('click', '#userMenu', function() {
    openModal();
});

// 点击模态框外部关闭
$(document).on('click', '#profileModal', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// 获取所有用户信息的函数（不调用）
function getUsers() {
    $.ajax({
        type: "get",
        url: "http://www.new.com:8081/getUsers.php",
        dataType: "json",
        success: function(result) {
            if (result.code == 200) {
                console.log('用户列表:', result.data);
            } else if (result.code == 404) {
                console.log('无用户数据');
            } else {
                alert(result.msg);
            }
        },
        error: function() {
            alert('获取用户列表失败');
        }
    });
}