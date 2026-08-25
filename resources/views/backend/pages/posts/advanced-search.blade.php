<!-- Advanced Search Modal -->
<div class="modal fade" id="advancedSearchModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">البحث المتقدم</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('posts.index') }}" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>العنوان</label>
                                <input type="text" name="title" class="form-control" placeholder="البحث في العنوان">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>الحالة</label>
                                <select name="status" class="form-control">
                                    <option value="">الكل</option>
                                    <option value="1">منشور</option>
                                    <option value="0">مسودة</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>من تاريخ</label>
                                <input type="date" name="date_from" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>إلى تاريخ</label>
                                <input type="date" name="date_to" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>المحتوى</label>
                                <input type="text" name="content" class="form-control" placeholder="البحث في المحتوى">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">بحث</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>
