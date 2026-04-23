package docker

default allow := false

allow if input.local

allow if {
    input.image
    not input.image.user == "root"
    not input.image.user == ""
}

deny_msg contains msg if {
    input.image.user == "root"
    msg := "Image must not run as root user"
}

deny_msg contains msg if {
    input.image.user == ""
    msg := "Image must specify a non-root USER"
}

decision := {"allow": allow, "deny_msg": deny_msg}