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
    public partial class Form3 : Form
    {
        Form f2;   
        public Form3()
        {
            
            InitializeComponent();
            f2 = new Form2();
        }

        private void okB_Click(object sender, EventArgs e)
        {

            
            this.Close();

        }

        private void cancelB_Click(object sender, EventArgs e)
        {
            this.Close();
        }
    }
}
