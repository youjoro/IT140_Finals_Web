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

namespace Plant_Monitoring_System
{
    [Activity(Label = "plantdata")]
    public class plantdata : Activity
    {
        TextView temp, hum, moist, datetime;
        Button refresh, logout;
        protected override void OnCreate(Bundle savedInstanceState)
        {
            base.OnCreate(savedInstanceState);
            SetContentView(Resource.Layout.plantdata);
            temp = FindViewById<TextView>(Resource.Id.temp);
            hum = FindViewById<TextView>(Resource.Id.humidity);
            moist = FindViewById<TextView>(Resource.Id.moist);  
            datetime = FindViewById<TextView>(Resource.Id.datetime);    
            refresh = FindViewById<Button>(Resource.Id.refresh);
            logout = FindViewById<Button>(Resource.Id.logout);

            logout.Click += this.logoutUser;
        }

        public void logoutUser (object sender, EventArgs e)
        {
            Intent intent = new Intent(this, typeof(MainActivity));
            StartActivity(intent);
        }
    }
}