<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#maindata" role="tab" data-toggle="tab" class="nav-link active">Основные данные</a>
                        </li>
                        <li class="nav-item">
                            <a href="#additionaldata" data-toggle="tab" role="tab" class="nav-link">Дополнительные
                                данные</a>
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane active" id="maindata" role="tabpanel">
                            <div class="form-group">
                                <label for="title">Заголовок</label>
                                <input name="title" value="{{ $item->title }}"
                                       id="title"
                                       type="text"
                                       class="form-control"
                                       minlength="3"
                                       required>
                            </div>


                            <div class="form-group">
                                <label for="content_raw">Описание</label>
                                <textarea class="form-control"
                                          name="content_raw"
                                          id="content_raw"
                                          rows="20">{{ old('content_raw', $item->content_raw) }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="additionaldata">

                            <div class="form-group">
                                <label for="parent_id">Родитель</label>
                                <select name="parent_id"
                                        id="parent_id"
                                        class="form-control"
                                        placeholder="Выберите категорию"
                                        required>
                                    @foreach($categoryList as $category)
                                        <option value="{{ $category->id }}"
                                                @if($category->id == $item->category_id) selected @endif>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="slug">Индефикатор</label>
                                <input name="slug" value="{{ $item->slug }}"
                                       id="slug"
                                       type="text"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="excerpt">Выдержка</label>
                                <textarea class="form-control"
                                          name="excerpt"
                                          id="excerpt"
                                          rows="5">{{ old('excerpt', $item->excerpt) }}</textarea>
                            </div>

                            <div class="form-check">
                                <input name="is_published"
                                       type="hidden"
                                       value="0">
                                <input name="is_published"
                                       type="checkbox"
                                       class="form-check-input"
                                       id="is_published"
                                       value="1"
                                    @if($item->is_published)
                                       checked="checked"
                                    @endif>

                                <label for="is_published" class="form-check-label">Опубликовано</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
