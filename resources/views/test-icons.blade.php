<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار الأيقونات - Icons Test</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Include Icons Fix -->
    @include('layouts.icons-fix')
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-5">اختبار الأيقونات - Icons Test Page</h1>
    
    <!-- Test Common Icons -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h3>الأيقونات الشائعة - Common Icons</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-check-circle fa-3x text-success"></i>
                    <p>fas fa-check-circle</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-times-circle fa-3x text-danger"></i>
                    <p>fas fa-times-circle</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-info-circle fa-3x text-info"></i>
                    <p>fas fa-info-circle</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-exclamation-circle fa-3x text-warning"></i>
                    <p>fas fa-exclamation-circle</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-home fa-3x text-primary"></i>
                    <p>fas fa-home</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-user fa-3x text-secondary"></i>
                    <p>fas fa-user</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-bell fa-3x text-warning"></i>
                    <p>fas fa-bell</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-heart fa-3x text-danger"></i>
                    <p>fas fa-heart</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-star fa-3x text-warning"></i>
                    <p>fas fa-star</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-trash fa-3x text-danger"></i>
                    <p>fas fa-trash</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-edit fa-3x text-info"></i>
                    <p>fas fa-edit</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-save fa-3x text-success"></i>
                    <p>fas fa-save</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Test Action Icons -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h3>أيقونات الإجراءات - Action Icons</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-plus fa-3x text-success"></i>
                    <p>fas fa-plus</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-minus fa-3x text-danger"></i>
                    <p>fas fa-minus</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-check fa-3x text-success"></i>
                    <p>fas fa-check</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-times fa-3x text-danger"></i>
                    <p>fas fa-times</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-download fa-3x text-primary"></i>
                    <p>fas fa-download</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-upload fa-3x text-info"></i>
                    <p>fas fa-upload</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-search fa-3x text-secondary"></i>
                    <p>fas fa-search</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-filter fa-3x text-warning"></i>
                    <p>fas fa-filter</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Test Navigation Icons -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h3>أيقونات التنقل - Navigation Icons</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-bars fa-3x"></i>
                    <p>fas fa-bars</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-ellipsis-v fa-3x"></i>
                    <p>fas fa-ellipsis-v</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-angle-left fa-3x"></i>
                    <p>fas fa-angle-left</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-angle-right fa-3x"></i>
                    <p>fas fa-angle-right</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Test Business Icons -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h3>أيقونات الأعمال - Business Icons</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-calendar fa-3x text-primary"></i>
                    <p>fas fa-calendar</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-calendar-alt fa-3x text-info"></i>
                    <p>fas fa-calendar-alt</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-clock fa-3x text-secondary"></i>
                    <p>fas fa-clock</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="far fa-clock fa-3x text-secondary"></i>
                    <p>far fa-clock</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-phone fa-3x text-success"></i>
                    <p>fas fa-phone</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-envelope fa-3x text-danger"></i>
                    <p>fas fa-envelope</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-map-marker-alt fa-3x text-danger"></i>
                    <p>fas fa-map-marker-alt</p>
                </div>
                <div class="col-md-3 col-6 mb-3 text-center">
                    <i class="fas fa-shopping-cart fa-3x text-warning"></i>
                    <p>fas fa-shopping-cart</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Test Status -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h3>حالة المكتبات - Libraries Status</h3>
        </div>
        <div class="card-body">
            <div id="status-container"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusContainer = document.getElementById('status-container');
    let statusHTML = '<ul class="list-group">';
    
    // Check Font Awesome 6
    const fa6Test = document.createElement('i');
    fa6Test.className = 'fa-solid fa-check';
    document.body.appendChild(fa6Test);
    const fa6Style = window.getComputedStyle(fa6Test, ':before');
    const fa6Loaded = fa6Style.fontFamily.includes('Font Awesome');
    statusHTML += `<li class="list-group-item">
        Font Awesome 6: ${fa6Loaded ? '<span class="badge bg-success">✓ Loaded</span>' : '<span class="badge bg-danger">✗ Not Loaded</span>'}
    </li>`;
    document.body.removeChild(fa6Test);
    
    // Check Font Awesome 5
    const fa5Test = document.createElement('i');
    fa5Test.className = 'fas fa-check';
    document.body.appendChild(fa5Test);
    const fa5Style = window.getComputedStyle(fa5Test, ':before');
    const fa5Loaded = fa5Style.fontFamily.includes('Font Awesome');
    statusHTML += `<li class="list-group-item">
        Font Awesome 5: ${fa5Loaded ? '<span class="badge bg-success">✓ Loaded</span>' : '<span class="badge bg-danger">✗ Not Loaded</span>'}
    </li>`;
    document.body.removeChild(fa5Test);
    
    // Check Bootstrap Icons
    const biTest = document.querySelector('.bi');
    statusHTML += `<li class="list-group-item">
        Bootstrap Icons: ${biTest ? '<span class="badge bg-success">✓ Available</span>' : '<span class="badge bg-warning">⚠ Not Used</span>'}
    </li>`;
    
    // Check Material Icons
    const miTest = document.querySelector('.material-icons');
    statusHTML += `<li class="list-group-item">
        Material Icons: ${miTest ? '<span class="badge bg-success">✓ Available</span>' : '<span class="badge bg-warning">⚠ Not Used</span>'}
    </li>`;
    
    // Count visible icons
    const allIcons = document.querySelectorAll('i[class*="fa-"]');
    let visibleCount = 0;
    allIcons.forEach(icon => {
        const beforeContent = window.getComputedStyle(icon, ':before').content;
        if (beforeContent && beforeContent !== 'none' && beforeContent !== '""') {
            visibleCount++;
        }
    });
    
    statusHTML += `<li class="list-group-item">
        Icons Status: <strong>${visibleCount}/${allIcons.length}</strong> icons visible
        ${visibleCount === allIcons.length ? '<span class="badge bg-success ms-2">✓ All Working</span>' : '<span class="badge bg-danger ms-2">✗ Some Missing</span>'}
    </li>`;
    
    statusHTML += '</ul>';
    
    // Add fix button
    statusHTML += `
        <div class="mt-3">
            <button class="btn btn-primary" onclick="if(typeof fixFontAwesomeIcons === 'function') { fixFontAwesomeIcons(); location.reload(); }">
                <i class="fas fa-sync-alt"></i> Force Refresh Icons
            </button>
        </div>
    `;
    
    statusContainer.innerHTML = statusHTML;
});
</script>
</body>
</html>
