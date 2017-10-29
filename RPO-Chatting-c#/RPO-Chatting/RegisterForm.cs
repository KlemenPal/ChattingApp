using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace RPO_Chatting
{
    public partial class RegisterForm : Form
    {
        Baza_Settings baza;
        public RegisterForm()
        {
            InitializeComponent();
            baza = new Baza_Settings();
        }

        private void cancelB_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        public void Register_Click(object sender, EventArgs e)
        {
            this.Close();
            
        }
    }
}
