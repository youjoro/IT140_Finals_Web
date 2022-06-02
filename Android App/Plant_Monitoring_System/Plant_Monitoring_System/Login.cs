using Android.App;
using Android.Content;
using Android.OS;
using Android.Runtime;
using Android.Views;
using Android.Widget;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net.Http;
using Xamarin.Essentials;

namespace Plant_Monitoring_System
{
    [Activity(Label = "Plant Monitoring System", MainLauncher = true)]
    public class Login : Activity
    {
        EditText email, pass;
        Button login, reg;
        HttpClient client;

        protected override void OnCreate(Bundle savedInstanceState)
        {
            base.OnCreate(savedInstanceState);

            SetContentView(Resource.Layout.login);

            email = FindViewById<EditText>(Resource.Id.email);
            pass = FindViewById<EditText>(Resource.Id.pass);
            login = FindViewById<Button>(Resource.Id.login);
            reg = FindViewById<Button>(Resource.Id.register);

            login.Click += this.loginUser;
            reg.Click += this.registerUser;
        }

        public void loginUser(object sender, EventArgs e)
        {
            bool isValid = valid_user(email.Text, pass.Text);
            if (!isValid)
            {
                return;
            }

            Preferences.Set("USER_EMAIL", email.Text);

            Intent intent = new Intent(this, typeof(MainActivity));
            StartActivity(intent);
            Finish();

        }
        public void registerUser(object sender, EventArgs e)
        {
            Intent intent = new Intent(this, typeof(Register));
            StartActivity(intent);
            Finish();
        }

        public bool valid_user(string email, string password)
        {
            client = new HttpClient();
            string api = "http://192.168.68.186:8080/IT140_Finals_Web/restAPI/verify_user.php";
            api += $"?email={email}";
            api += $"&password={password}";

            var api_uri = new Uri(api);

            var response = client.GetAsync(api_uri).Result;
            var parsed_response = response.Content.ReadAsStringAsync().Result;

            if (String.IsNullOrEmpty(parsed_response))
            {
                return false;
            }

            return true;
            
        }
    }
}