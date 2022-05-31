using Android.App;
using Android.Content;
using Android.OS;
using Android.Runtime;
using Android.Widget;
using AndroidX.AppCompat.App;
using System;

namespace Plant_Monitoring_System
{
    [Activity(Label = "Plant Monitoring System", Theme = "@style/AppTheme")]
    public class MainActivity : AppCompatActivity
    {
        TextView temp, hum, moist, datetime;
        Button refresh, logout;
        protected override void OnCreate(Bundle savedInstanceState)
        {
            base.OnCreate(savedInstanceState);
            Xamarin.Essentials.Platform.Init(this, savedInstanceState);
            SetContentView(Resource.Layout.plantdata);

            temp = FindViewById<TextView>(Resource.Id.temp);
            hum = FindViewById<TextView>(Resource.Id.humidity);
            moist = FindViewById<TextView>(Resource.Id.moist);
            datetime = FindViewById<TextView>(Resource.Id.datetime);
            refresh = FindViewById<Button>(Resource.Id.refresh);
            logout = FindViewById<Button>(Resource.Id.logout);

            logout.Click += this.logoutUser;

        }

        public override void OnRequestPermissionsResult(int requestCode, string[] permissions, [GeneratedEnum] Android.Content.PM.Permission[] grantResults)
        {
            Xamarin.Essentials.Platform.OnRequestPermissionsResult(requestCode, permissions, grantResults);

            base.OnRequestPermissionsResult(requestCode, permissions, grantResults);
        }

        public void logoutUser(object sender, EventArgs e)
        {
            Intent intent = new Intent(this, typeof(Login));
            StartActivity(intent);
            Finish();
        }
    }
}