namespace RPO_Chatting
{
    partial class RegisterForm
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.textBox1 = new System.Windows.Forms.TextBox();
            this.textBox2 = new System.Windows.Forms.TextBox();
            this.usText = new System.Windows.Forms.Label();
            this.pwText = new System.Windows.Forms.Label();
            this.Register = new System.Windows.Forms.Button();
            this.cancelB = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // textBox1
            // 
            this.textBox1.Location = new System.Drawing.Point(98, 50);
            this.textBox1.Name = "textBox1";
            this.textBox1.Size = new System.Drawing.Size(100, 20);
            this.textBox1.TabIndex = 0;
            // 
            // textBox2
            // 
            this.textBox2.Location = new System.Drawing.Point(98, 97);
            this.textBox2.Name = "textBox2";
            this.textBox2.Size = new System.Drawing.Size(100, 20);
            this.textBox2.TabIndex = 1;
            // 
            // usText
            // 
            this.usText.AutoSize = true;
            this.usText.Location = new System.Drawing.Point(27, 53);
            this.usText.Name = "usText";
            this.usText.Size = new System.Drawing.Size(58, 13);
            this.usText.TabIndex = 2;
            this.usText.Text = "Username:";
            // 
            // pwText
            // 
            this.pwText.AutoSize = true;
            this.pwText.Location = new System.Drawing.Point(27, 100);
            this.pwText.Name = "pwText";
            this.pwText.Size = new System.Drawing.Size(56, 13);
            this.pwText.TabIndex = 3;
            this.pwText.Text = "Password:";
            // 
            // Register
            // 
            this.Register.Location = new System.Drawing.Point(52, 145);
            this.Register.Name = "Register";
            this.Register.Size = new System.Drawing.Size(75, 23);
            this.Register.TabIndex = 4;
            this.Register.Text = "Register";
            this.Register.UseVisualStyleBackColor = true;
            this.Register.Click += new System.EventHandler(this.Register_Click);
            // 
            // cancelB
            // 
            this.cancelB.Location = new System.Drawing.Point(149, 145);
            this.cancelB.Name = "cancelB";
            this.cancelB.Size = new System.Drawing.Size(75, 23);
            this.cancelB.TabIndex = 5;
            this.cancelB.Text = "Cancel";
            this.cancelB.UseVisualStyleBackColor = true;
            this.cancelB.Click += new System.EventHandler(this.cancelB_Click);
            // 
            // RegisterForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(284, 199);
            this.Controls.Add(this.cancelB);
            this.Controls.Add(this.Register);
            this.Controls.Add(this.pwText);
            this.Controls.Add(this.usText);
            this.Controls.Add(this.textBox2);
            this.Controls.Add(this.textBox1);
            this.Name = "RegisterForm";
            this.Text = "RegisterForm";
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.TextBox textBox1;
        private System.Windows.Forms.TextBox textBox2;
        private System.Windows.Forms.Label usText;
        private System.Windows.Forms.Label pwText;
        private System.Windows.Forms.Button Register;
        private System.Windows.Forms.Button cancelB;
    }
}