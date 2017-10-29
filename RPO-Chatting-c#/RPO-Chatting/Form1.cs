using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using MySql.Data.MySqlClient;

namespace RPO_Chatting
{
    public partial class Form1 : Form
    {
        Baza_Settings baza; 
    
        public Form1()
        {
            InitializeComponent();
            baza = new Baza_Settings();
        }

        private void loginbutton_Click(object sender, EventArgs e)
        {
            if (string.IsNullOrWhiteSpace(usernameText.Text) || string.IsNullOrWhiteSpace(passwordText.Text))
            {
                MessageBox.Show("Prazno polje");
            }
            else
            {
                
                string username = usernameText.Text.ToString();
                string password = passwordText.Text.ToString();
                MySqlDataReader reader = baza.Select("SELECT * FROM uporabnik WHERE username = '" + username+"'");
                string saved_pwd = null;
                while (reader.Read())
                {
                    saved_pwd=reader["password"].ToString();
                    
                }
                if (password == saved_pwd)
                {
                    this.Hide();
                    var glavni_meni = new Form2();
                    glavni_meni.Closed += (s, args) => this.Close();
                    glavni_meni.Show();
                }
                //close Data Reader
                reader.Close();
                
                
                baza.CloseConnection();

            }

        }

        private void passwordText_TextChanged(object sender, EventArgs e)
        {
            passwordText.PasswordChar = '*';
            passwordText.TextAlign = HorizontalAlignment.Center;
        }

        private void registerB_Click(object sender, EventArgs e)
        {
            RegisterForm registracija = new RegisterForm();
            if (registracija.ShowDialog() == DialogResult.OK)
            {

            }
        }
    }
}
