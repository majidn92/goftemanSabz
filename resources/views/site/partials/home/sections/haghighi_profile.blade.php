<section id="section-haghighi">
    <div style="width: 90%;margin: auto">
        <h2 class="section-title" style="color:#08a9a8">پروفایل کاربران منتخب</h2>
        <div class="section-box" style="border-top: solid #08a9a8">
            <div class="featured-profile">
                @foreach ($haghighi_profiles as $haghighi_profile)
                    <a href="{{ url("author-profile/$hoghooghi_profile->id") }}">
                        <div class="profile-box text-center p-1">
                            <img src="{{ static_asset($haghighi_profile->profile_image) }}" style="margin: auto">
                            <div>
                                {{ $haghighi_profile->first_name }} {{ $haghighi_profile->last_name }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
