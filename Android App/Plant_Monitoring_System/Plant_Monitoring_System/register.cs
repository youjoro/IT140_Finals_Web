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

namespace Plant_Monitoring_System
{
    [Activity(Label = "Register to Plant Monitoring System", Theme = "@style/AppTheme")]
    public class Register : Activity
    {
        EditText email, pass;
        Button reg, cancel;
        HttpClient client;
        protected override void OnCreate(Bundle savedInstanceState)
        {
            base.OnCreate(savedInstanceState);

            SetContentView(Resource.Layout.register);
            email = FindViewById<EditText>(Resource.Id.email);
            pass = FindViewById<EditText>(Resource.Id.pass);
            reg = FindViewById<Button>(Resource.Id.register);
            cancel = FindViewById<Button>(Resource.Id.cancel);

            reg.Click += this.register_user;
            cancel.Click += this.cancelReg;
        }

        public void register_user(object sender, EventArgs e)
        {
            add_user(email.Text, pass.Text);

            Intent intent = new Intent(this, typeof(Login));
            StartActivity(intent);
            Finish();
        }
        public void cancelReg(object sender, EventArgs e)
        {
            Intent intent = new Intent(this, typeof(Login));
            StartActivity(intent);
            Finish();
        }

        public void add_user(string email, string password)
        {
            client = new HttpClient();
            string api = "http://192.168.68.186:8080/IT140_Finals_Web/restAPI/add_user.php";
            api += $"?email={email}";
            api += $"&password={password}";

            var api_uri = new Uri(api);

            var response = client.GetAsync(api_uri).Result;
        }
    }
}