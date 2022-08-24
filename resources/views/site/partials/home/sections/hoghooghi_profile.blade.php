<section id="section-hoghooghi">
    <div style="width: 90%;margin: auto">
        <h2 class="section-title" style="color:#08a9a8">پروفایل سازمان ها و شرکت های منتخب</h2>
        <div class="section-box" style="border-top: solid #08a9a8">
            <div class="featured-profile">
                @foreach ($hoghooghi_profiles as $hoghooghi_profile)
                    <a href="{{url("author-profile/$hoghooghi_profile->id")}}">
                        <div class="profile-box">
                            <img src="{{ static_asset($hoghooghi_profile->profile_image) }}" style="margin: auto">
                            <div>
                                {{ $hoghooghi_profile->first_name }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
