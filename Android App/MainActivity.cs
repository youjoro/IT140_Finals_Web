using Android.App;
using Android.Content;
using Android.OS;
using Android.Runtime;
using Android.Widget;
using AndroidX.AppCompat.App;
using System;

namespace Plant_Monitoring_System
{
    [Activity(Label = "Log in to Plant Monitoring System", Theme = "@style/AppTheme", MainLauncher = true)]
    public class MainActivity : AppCompatActivity
    {
        EditText email, pass;
        Button login, reg;
        protected override void OnCreate(Bundle savedInstanceState)
        {
            base.OnCreate(savedInstanceState);
            Xamarin.Essentials.Platform.Init(this, savedInstanceState);
            SetContentView(Resource.Layout.activity_main);

            email = FindViewById<EditText>(Resource.Id.email);
            pass = FindViewById<EditText>(Resource.Id.pass);
            login = FindViewById<Button>(Resource.Id.login);
            reg = FindViewById<Button>(Resource.Id.register);

            login.Click += this.loginUser;
            reg.Click += this.registerUser;

        }
        public void loginUser(object sender, EventArgs e)
        {
            if  (email.Text == "wouh" && pass.Text == "69")
            {
                Intent intent = new Intent(this, typeof(plantdata));
                StartActivity(intent);
            }

        }
        public void registerUser(object sender, EventArgs e)
        {
            Intent intent = new Intent(this, typeof(register));
            StartActivity(intent);
        }

        public override void OnRequestPermissionsResult(int requestCode, string[] permissions, [GeneratedEnum] Android.Content.PM.Permission[] grantResults)
        {
            Xamarin.Essentials.Platform.OnRequestPermissionsResult(requestCode, permissions, grantResults);

            base.OnRequestPermissionsResult(requestCode, permissions, grantResults);
        }
    }
}